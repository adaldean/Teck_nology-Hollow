<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\Controller;
use Whoops\Run;

// Llama al método 'index' del ProductoController, el cual carga la vista 'inicio' con datos.
Route::get('/', [ProductoController::class, 'index']);

// RUTA INVENTARIO (/inventario)
// Llama al método 'showInventory' del ProductoController, el cual carga la vista 'inventario' con datos.
Route::get('/inventario', [ProductoController::class, 'showInventory']); 

Route::get('/privado/login', function () {
    return view('privado.login');
});