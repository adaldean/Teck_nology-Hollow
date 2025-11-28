<?php

use App\Http\Controllers\ProductoController;

Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');


