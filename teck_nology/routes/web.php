<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;

// --- RUTAS DE INICIO (HOME) y PRODUCTO ---
Route::get('/', [ProductoController::class, 'index'])->name('inicio');
Route::get('/carrito', [ProductoController::class, 'showCart'])->name('carrito');

// --- RUTAS DE AUTENTICACIÓN (LOGIN) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- RUTAS DE INVENTARIO (PROTEGIDAS por Auth Middleware) ---
Route::middleware('auth')->group(function () {

    // Inventario
    Route::get('privado/inventario', [ProductoController::class, 'showInventory'])->name('inventario.index');
    Route::get('/inventario/{id}', [ProductoController::class, 'show'])->name('inventario.show');
    Route::get('/inventario/agregar', [ProductoController::class, 'create'])->name('inventario.create');
    Route::post('/inventario/guardar', [ProductoController::class, 'store'])->name('inventario.store');
    Route::get('/inventario/editar/{id}', [ProductoController::class, 'edit'])->name('inventario.edit'); 
    Route::post('/inventario/actualizar/{id}', [ProductoController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/eliminar/{id}', [ProductoController::class, 'destroy'])->name('inventario.destroy');

    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::delete('/usuarios/{id}/eliminar', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});
