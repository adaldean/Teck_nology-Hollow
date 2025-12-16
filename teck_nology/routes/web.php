<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ImageUploadController;

// Excluir la URI de subida de imágenes de la verificación CSRF para permitir uploads desde
// páginas estáticas o clientes externos. Si prefieres protegerla, elimina esta línea
// y gestiona CSRF o auth según corresponda.
\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::except(["/imagenes/upload"]);

// Ruta de desarrollo: acceso público al formulario de 'Agregar producto' sin auth (quitar antes de producir)
Route::get('/dev/inventario/agregar', [ProductoController::class, 'create']);

// --- RUTAS DE INICIO (HOME) y PRODUCTO ---
Route::get('/', [ProductoController::class, 'index'])->name('inicio');
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.show');
use App\Http\Controllers\CartController;

// Cart routes
Route::get('/carrito', [CartController::class, 'show'])->name('carrito');

// Serve frontend images located in the repository's frontend/imagenes folder
// (development helper so catalog can use static images from frontend/imagenes)
Route::get('/imagenes/static/{filename}', function ($filename) {
    $path = base_path('../frontend/imagenes/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    $mime = mime_content_type($path) ?: 'application/octet-stream';
    return response()->file($path, ['Content-Type' => $mime]);
})->where('filename', '.*');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('carrito.agregar');
Route::post('/carrito/actualizar', [CartController::class, 'update'])->name('carrito.update');
Route::post('/carrito/eliminar', [CartController::class, 'remove'])->name('carrito.remove');
Route::get('/carrito/count', [CartController::class, 'count'])->name('carrito.count');
Route::post('/carrito/checkout', [CartController::class, 'checkout'])->name('carrito.checkout');
Route::get('/carrito/confirmacion', [CartController::class, 'confirmation'])->name('carrito.confirmation');

// --- RUTAS DE AUTENTICACIÓN (LOGIN) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro público de clientes (formulario y envío)
Route::get('/registro', [LoginController::class, 'showRegistroForm'])->name('registro.form');
Route::post('/registro', [LoginController::class, 'register'])->name('registro.post');

// Logout específico para clientes (limpia session cliente)
Route::get('/cliente/logout', [LoginController::class, 'logoutCliente'])->name('cliente.logout');

// Rutas de desarrollo: solo habilitar cuando APP_ENV=local
if (app()->environment('local')) {
    // Crear un cliente de prueba rápidamente (dev)
    Route::get('/dev/registro/seed', [LoginController::class, 'seedDevClient']);
    Route::get('/dev/registro/login', [LoginController::class, 'devLogin']);
}

// --- RUTAS DE INVENTARIO (PROTEGIDAS por Auth Middleware) ---
// Endpoint público para subir imágenes desde el frontend (retorna JSON {url})
// Nota: Puedes protegerlo con middleware('auth') si quieres que solo usuarios autenticados suban imágenes.
Route::post('/imagenes/upload', [ImageUploadController::class, 'store'])->name('imagenes.upload');

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
    Route::get('/clientes/listar', [ClienteController::class, 'listar'])->name('clientes.listar');
    Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes/guardar', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/editar/{id}', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}/actualizar', [ClienteController::class, 'actualizarAjax'])->name('clientes.actualizarAjax');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});

// Rutas de desarrollo no protegidas para pruebas rápidas (habilitadas solo en local)
if (app()->environment('local')) {
    Route::get('/dev/inventario/agregar', [ProductoController::class, 'create']);
    Route::post('/dev/inventario/guardar', [ProductoController::class, 'store']);
}