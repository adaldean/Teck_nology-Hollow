<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController; // Importa tu controlador

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí registramos las rutas para que la URL principal llame a tu controlador.
|
*/

// La ruta principal (/) llama al método 'index' del ProductoController.
// Este es el método que obtiene los productos y pasa la variable $productos a la vista 'inicio'.
Route::get('/', [ProductoController::class, 'index']);

// Si necesitas una ruta simple de inventario sin pasar datos de productos:
Route::get('/inventario', function () {
    return view('inventario');
});