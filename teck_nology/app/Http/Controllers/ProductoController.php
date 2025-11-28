<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Usamos el Modelo Producto (Eloquent) en lugar de Illuminate\Support\Facades\DB
use App\Models\Producto; 

class ProductoController extends Controller
{
    public function index()
    {
        // Trae todos los productos usando el Modelo Eloquent
        // Si la tabla 'producto' está vacía, devuelve una colección vacía.
        $productos = Producto::all();

        // Retorna la vista 'inicio.blade.php' y le pasa la variable $productos
        return view('inicio', compact('productos'));
    }
    public function showInventory()
    {
        // Usa el modelo para traer todos los productos
        $productos = Producto::all(); 

        // Retorna la vista 'inventario.blade.php' y le pasa la variable $productos
        return view('privado/inventario', compact('productos'));
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
        // Aquí puedes implementar la lógica para mostrar un producto específico
        // Por ejemplo, podrías obtener el ID del producto desde la solicitud
        // y luego buscar ese producto en la base de datos.
        return view('producto'); // Retorna la vista 'producto.blade.php'
    }
} 