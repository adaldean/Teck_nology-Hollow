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
}