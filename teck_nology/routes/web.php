<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;

// --- RUTAS DE INICIO (HOME) y PRODUCTO ---
Route::get('/', [ProductoController::class, 'index'])->name('inicio');
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.show');
Route::get('/carrito', [ProductoController::class, 'showCart'])->name('carrito');

// --- RUTAS DE AUTENTICACIÓN (LOGIN) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- RUTAS DE INVENTARIO (PROTEGIDAS por Auth Middleware) ---
Route::middleware('auth')->group(function () {
    Route::get('/privado/home', function () {
        return view('privado.home');
    })->name('privado.home');   

    // --- RUTAS DE BÚSQUEDA ---
    Route::get('/inventario/buscar', [ProductoController::class, 'buscar'])->name('inventario.buscar');
    Route::get('/inventario/categoria', [ProductoController::class, 'filtrarPorCategoria'])->name('inventario.categoria');
    Route::get('/usuarios/buscar', [UsuarioController::class, 'buscar'])->name('usuarios.buscar');
    Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');

    // Inventario
    Route::get('privado/inventario', [ProductoController::class, 'showInventory'])->name('inventario.index');
    Route::get('/inventario/{id}', [ProductoController::class, 'show'])->name('inventario.show');
    Route::get('/inventario/agregar', [ProductoController::class, 'create'])->name('inventario.create');
    Route::post('/inventario/guardar', [ProductoController::class, 'store'])->name('inventario.store');
    Route::get('/inventario/editar/{id}', [ProductoController::class, 'edit'])->name('inventario.edit'); 
    Route::post('/inventario/actualizar/{id}', [ProductoController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/eliminar/{id}', [ProductoController::class, 'destroy'])->name('inventario.destroy');

    // **RUTAS DE USUARIOS (Empleados)**
    Route::prefix('privado/usuarios')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/guardar', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::post('/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/{id}/eliminar', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::get('/rol', [UsuarioController::class, 'rol'])->name('usuarios.rol');
    });

    // **RUTAS DE CLIENTES (Nuevas)**
    Route::prefix('privado/usuarios')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/guardar', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::post('/{id}/actualizar', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/{id}/eliminar', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });
});