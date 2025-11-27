// app/Services/VentaService.php

<?php

namespace App\Services;

use App\Models\VentaPos;
use App\Models\Producto;
use App\Models\ProgramaLealtad;
use Illuminate\Support\Facades\DB;

class VentaService
{
    /**
     * Procesa una venta POS, incluyendo detalles, stock y puntos de lealtad.
     * @param int $empleadoId
     * @param int $tiendaId
     * @param array $detalles
     * @param int|null $clienteId (Para lealtad)
     * @return VentaPos
     */
    public function procesarVenta(int $empleadoId, int $tiendaId, array $detalles, ?int $clienteId = null): VentaPos
    {
        // Usamos una transacción para asegurar que todas las operaciones se completan
        return DB::transaction(function () use ($empleadoId, $tiendaId, $detalles, $clienteId) {
            
            $totalVenta = 0;
            
            // 1. Calcular el total de la venta y asegurar el stock
            foreach ($detalles as $item) {
                $producto = Producto::findOrFail($item['id_producto']);
                
                // Validación de stock
                if ($producto->stock < $item['cantidad']) {
                    // Si no hay stock, se lanza una excepción y la transacción se revierte
                    throw new \Exception("Stock insuficiente para: " . $producto->nombre);
                }
                
                // El precio se toma del producto actual para evitar fraudes
                $item['precio'] = $producto->precio; 
                $totalVenta += ($item['precio'] * $item['cantidad']);
            }

            // 2. Crear el registro principal de la Venta POS
            $venta = VentaPos::create([
                'id_empleado' => $empleadoId,
                'id_tienda'   => $tiendaId,
                'fecha_venta' => now(),
                'total'       => $totalVenta,
            ]);

            // 3. Registrar los detalles de la venta y actualizar el stock
            foreach ($detalles as $item) {
                // Agregar el detalle de la venta (usando la relación si ya está definida en el modelo)
                $venta->detalles()->create([
                    'id_producto' => $item['id_producto'],
                    'cantidad'    => $item['cantidad'],
                    'precio'      => $item['precio'],
                ]);

                // Actualizar stock
                $this->actualizarStockProducto($item['id_producto'], $item['cantidad']);
            }
            
            // 4. Integración del Programa de Lealtad (si aplica)
            if ($clienteId) {
                $puntosGanados = floor($totalVenta / 100); // Ejemplo: 1 punto por cada $100
                $this->actualizarPuntosLealtad($clienteId, $puntosGanados);
            }

            return $venta;
        });
    }

    /**
     * Lógica auxiliar para actualizar el stock. (Podría delegar al InventarioService)
     */
    protected function actualizarStockProducto(int $productoId, int $cantidadVendida): void
    {
        // En una aplicación real, idealmente delegarías esto al InventarioService
        Producto::where('id_producto', $productoId)->decrement('stock', $cantidadVendida);
    }

    /**
     * Lógica auxiliar para actualizar puntos de lealtad.
     */
    protected function actualizarPuntosLealtad(int $clienteId, int $puntos): void
    {
        $programa = ProgramaLealtad::firstOrCreate(
            ['id_cliente' => $clienteId],
            ['puntos' => 0]
        );

        $programa->increment('puntos', $puntos);
    }
}