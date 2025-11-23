// app/Http/Controllers/Api/VentaPOSController.php

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVentaPOSRequest; // El Form Request creado
use App\Services\VentaService;              // El VentaService creado

class VentaPOSController extends Controller
{
    protected $ventaService;

    // Inyección del VentaService
    public function __construct(VentaService $ventaService)
    {
        $this->ventaService = $ventaService;
    }

    /**
     * Procesa la creación de una nueva Venta POS.
     * Utiliza el VentaService para manejar la lógica transaccional.
     */
    public function store(StoreVentaPOSRequest $request)
    {
        // Los datos ya están validados en este punto
        $data = $request->validated();
        
        try {
            // Delega la lógica de negocio compleja al Servicio
            $venta = $this->ventaService->procesarVenta(
                $data['id_empleado'],
                $data['id_tienda'],
                $data['detalles'],
                $data['id_cliente'] ?? null // Pasa null si el cliente no está presente
            );

            return response()->json([
                'message' => 'Venta POS registrada y stock actualizado exitosamente.',
                'venta' => $venta
            ], 201); // 201 Created
            
        } catch (\Exception $e) {
            // Captura cualquier excepción lanzada por el Servicio (ej. Stock insuficiente)
            return response()->json([
                'message' => 'Error al procesar la venta.',
                'error' => $e->getMessage()
            ], 400); // 400 Bad Request
        }
    }
    
    // ... otros métodos (index, show) para consultar ventas
}