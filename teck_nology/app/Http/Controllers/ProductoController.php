<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function showcart()
    {
        return view('carrito'); 
    }

    public function showInventory()
    {
        $productos = Producto::all();
        return view('privado/inventario', compact('productos'));
    }

    public function index(Request $request)
    {
        $categoria = $request->get('nombre');
        $orden = $request->get('orden');

        $query = Producto::query();

        if ($categoria) {
            $query->where('id_categoria', $categoria);
        }

        if ($orden == 'asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden == 'desc') {
            $query->orderBy('precio', 'desc');
        } elseif ($orden == 'ofertas') {
            $query->where('precio', '<', 500); 
        }

        $productos = $query->paginate(12);

        return view('inicio', compact('productos'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('privado/editar_producto', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return redirect('/inventario')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect('/inventario')->with('success', 'Producto eliminado correctamente.');   
    }

    public function create()
    {
        return view('privado/agregar_producto');
    }

    public function store(Request $request)
    {
        Producto::create($request->all());
        return redirect('/inventario')->with('success', 'Producto agregado correctamente.');
    }

    public function show()
    {
        return view('producto'); 
    }
    
    public function buscar(Request $request)
{
    $query = $request->input('query');

    $productos = Producto::with(['categoria','proveedor'])
        ->where('id_producto', 'LIKE', "%{$query}%")
        ->orwhere('nombre', 'LIKE', "%{$query}%")
        ->orWhere('descripcion', 'LIKE', "%{$query}%")
        ->orWhereHas('categoria', function($q) use ($query) {
            $q->where('nombre', 'LIKE', "%{$query}%");
        })
        ->orWhereHas('proveedor', function($q) use ($query) {
            $q->where('nombre', 'LIKE', "%{$query}%");
        })
        ->paginate(10);

    return view('partials.tabla_productos', compact('productos'));
}

    public function filtrarPorCategoria(Request $request)
{
    $categoria = $request->input('categoria');
    if ($categoria === 'todos') {
        $productos = Producto::with('categoria')->paginate(10);
        return view('partials.tabla_productos', compact('productos'));  
    } else {
    $productos = Producto::with('categoria', 'proveedor')
        ->whereHas('categoria', function($q) use ($categoria) {
            $q->where('nombre', $categoria);
        })
        ->paginate(10);

    return view('partials.tabla_productos', compact('productos'));  

    }
}
}
