<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
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

        return view('catalogo', compact('productos'));
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
} 
