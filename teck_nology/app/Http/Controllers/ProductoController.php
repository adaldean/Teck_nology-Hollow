<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    public function showcart()
    {
        return view('carrito'); 
    }

    public function create()
    {
        // Muestra el formulario para crear un nuevo producto
        try {
            $categorias = Categoria::all();
            $proveedores = Proveedor::all();
        } catch (\Exception $e) {
            // Si hay un problema con la BD (p.ej. driver faltante), devolvemos colecciones vacías
            // y mostramos un mensaje para que el usuario pueda continuar.
            $categorias = collect();
            $proveedores = collect();
            // Use session flash so the view can show a warning
            session()->flash('error', 'No se pudieron cargar categorías/proveedores (problema de conexión a la BD). Podés crear el producto sin asignarlos.');
        }

        return view('privado.crear_producto', compact('categorias','proveedores'));
    }

    public function showInventory()
    {
        $productos = Producto::all();
        return view('privado/inventario', compact('productos'));
    }

    public function index(Request $request)
    {
        $categoria = $request->get('categoria'); // 👈 corregido
        $orden = $request->get('orden');

        $query = Producto::with(['categoria','proveedor']);

        if ($categoria && $categoria !== 'todos') {
            $query->whereHas('categoria', function($q) use ($categoria) {
                $q->where('nombre', $categoria);
            });
        }

        if ($orden === 'asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($orden === 'desc') {
            $query->orderBy('precio', 'desc');
        } elseif ($orden === 'ofertas') {
            $query->where('precio', '<', 500); 
        }

        $productos = $query->paginate(6); // 👈 coherente con catálogo

        return view('inicio', compact('productos'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('privado/editar_producto', compact('producto','categorias','proveedores'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric',
            'stock' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'nullable|integer|exists:categoria,id_categoria',
            'id_proveedor' => 'nullable|integer|exists:proveedor,id_proveedor',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

    $producto->update($validated);
    return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        try {
            // Eliminar registros relacionados en detalle_pedido antes de eliminar el producto
            DB::transaction(function() use ($id, $producto) {
                // Borrar registros en tablas que referencian producto
                DB::table('detalle_pedido')->where('id_producto', $id)->delete();
                DB::table('detalle_venta_pos')->where('id_producto', $id)->delete();
                $producto->delete();
            });

            return redirect()->route('inventario.index')->with('success', 'Producto y sus detalles relacionados fueron eliminados correctamente.');
        } catch (QueryException $e) {
            // Foreign key constraint or other DB error
            return redirect()->route('inventario.index')->with('error', 'No se puede eliminar el producto debido a un error de base de datos.');
        } catch (\Exception $e) {
            return redirect()->route('inventario.index')->with('error', 'Ocurrió un error al intentar eliminar el producto.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'precio' => 'required|numeric',
            'stock' => 'nullable|integer',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'nullable|integer|exists:categoria,id_categoria',
            'id_proveedor' => 'nullable|integer|exists:proveedor,id_proveedor',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);
    return redirect()->route('inventario.index')->with('success', 'Producto agregado correctamente.');
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
            ->orWhere('nombre', 'LIKE', "%{$query}%")
            ->orWhere('descripcion', 'LIKE', "%{$query}%")
            ->orWhereHas('categoria', function($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('proveedor', function($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%");
            })
            ->paginate(6); // 👈 coherente

        return view('partials.tabla_productos', compact('productos'));
    }

    public function filtrarPorCategoria(Request $request)
    {
        $categoria = $request->input('categoria');

        if ($categoria === 'todos') {
            $productos = Producto::with('categoria')->paginate(6);
        } else {
            $productos = Producto::with('categoria','proveedor')
                ->whereHas('categoria', function($q) use ($categoria) {
                    $q->where('nombre', $categoria);
                })
                ->paginate(6);
        }

        return view('partials.tabla_productos', compact('productos'));
    }
}
