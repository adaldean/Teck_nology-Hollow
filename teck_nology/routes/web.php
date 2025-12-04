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

    // Usuarios
    Route::get('privado/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::delete('/usuarios/{id}/eliminar', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::post('/usuarios/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios/rol', [UsuarioController::class, 'rol'])->name('usuarios.rol');
    // Clientes
    Route::get('privado/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/cliente/crear', [ClienteController::class, 'create'])->name('cliente.create');
    Route::get('/cliente/{id}/editar', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::delete('/cliente/{id}/eliminar', [ClienteController::class, 'destroy'])->name('cliente.destroy');
    Route::post('/cliente/guardar', [ClienteController::class, 'store'])->name('cliente.store');
    Route::post('/cliente/{id}/actualizar', [ClienteController::class, 'update'])->name('cliente.update');
});
