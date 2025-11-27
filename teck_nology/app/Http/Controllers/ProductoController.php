<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Usamos el Modelo Producto (Eloquent) en lugar de Illuminate\Support\Facades\DB
use App\Models\Producto; 
use App\Models\ProductoStock;

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
        // Trae todos los productos (incluyendo el nuevo campo 'stock')
        $productos = Producto::all(); 

        // Retorna la vista 'inventario.blade.php' con la colección de productos
        return view('inventario', compact('productos'));
    }
}