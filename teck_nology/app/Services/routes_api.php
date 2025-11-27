// routes/api.php

use App\Http\Controllers\Api\VentaPOSController;
use Illuminate\Support\Facades\Route;

// ... otras rutas (productos, clientes, etc.)

// Ruta para el Punto de Venta
Route::post('ventas-pos', [VentaPOSController::class, 'store']); 
// O si usarás todos los métodos RESTful:
// Route::apiResource('ventas-pos', VentaPOSController::class);