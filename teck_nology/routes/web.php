<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\LoginController;

// --- RUTAS DE INICIO (HOME) y PRODUCTO ---
// Llama al método 'index' del ProductoController, el cual carga la vista 'inicio' con datos.
Route::get('/', [ProductoController::class, 'index']);

// Muestra un producto individual
Route::get('/producto', [ProductoController::class, 'show']); 

// --- RUTAS DE AUTENTICACIÓN (LOGIN) ---
// Muestra el formulario de login (GET)
Route::get('private/login', [LoginController::class, 'showLoginForm'])->name('login');
// Procesa el formulario de login (POST)
Route::post('private/login', [LoginController::class, 'authenticate']);
// Ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- RUTAS DE INVENTARIO (PROTEGIDAS por Auth Middleware) ---
Route::middleware('auth')->group(function () {

    // Listado de inventario
    Route::get('privado/inventario', [ProductoController::class, 'showInventory']);

    // Crear nuevo producto
    Route::get('/inventario/agregar', [ProductoController::class, 'create']);
    Route::post('/inventario/guardar', [ProductoController::class, 'store']);

    // Editar producto
    Route::get('/inventario/editar/{id}', [ProductoController::class, 'edit']); 
    Route::post('/inventario/actualizar/{id}', [ProductoController::class, 'update']);

    // Eliminar producto
    Route::get('/inventario/eliminar/{id}', [ProductoController::class, 'destroy']);
});