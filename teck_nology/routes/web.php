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

    // --- INVENTARIO ---
    Route::get('privado/inventario', [ProductoController::class, 'showInventory'])->name('inventario.index');
    Route::get('/inventario/{id}', [ProductoController::class, 'show'])->name('inventario.show');
    Route::get('/inventario/agregar', [ProductoController::class, 'create'])->name('inventario.create');
    Route::post('/inventario/guardar', [ProductoController::class, 'store'])->name('inventario.store');
    Route::get('/inventario/editar/{id}', [ProductoController::class, 'edit'])->name('inventario.edit'); 
    Route::post('/inventario/actualizar/{id}', [ProductoController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/eliminar/{id}', [ProductoController::class, 'destroy'])->name('inventario.destroy');

    // --- USUARIOS (EMPLEADOS) ---
    Route::get('privado/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}/actualizar', [UsuarioController::class, 'actualizarAjax'])->name('usuarios.actualizarAjax');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // --- CLIENTES ---
    Route::get('privado/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes/guardar', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/editar/{id}', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}/actualizar', [ClienteController::class, 'actualizarAjax'])->name('clientes.actualizarAjax');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});