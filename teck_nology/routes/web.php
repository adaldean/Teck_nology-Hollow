<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\Controller;

// Llama al método 'index' del ProductoController, el cual carga la vista 'inicio' con datos.
Route::get('/', [ProductoController::class, 'index']);

// RUTA INVENTARIO (/inventario)
// Llama al método 'showInventory' del ProductoController, el cual carga la vista 'inventario' con datos.
Route::get('/inventario', [ProductoController::class, 'showInventory']); 

// La ruta Route::get('/inventario', function () { return view('inventario'); });
// se ha eliminado para que solo se use la versión del controlador.