// app/Services/InventarioService.php

<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class InventarioService
{
    /**
     * Crea un nuevo producto y asegura que la operación es atómica (transaccional).
     * @param array $data Los datos validados del producto.
     * @return Producto
     */
    public function crearProducto(array $data): Producto
    {
        // 1. Inicia una transacción para asegurar la integridad de la BD
        return DB::transaction(function () use ($data) {
            
            // 2. Crea el producto
            $producto = Producto::create($data);

            // 3. (Opcional) Aquí podría ir lógica adicional, como crear logs o notificaciones.
            
            return $producto;
        });
    }

    /**
     * Actualiza el stock de un producto después de una venta o pedido.
     * @param int $productoId El ID del producto.
     * @param int $cantidad La cantidad a restar (o sumar si es negativo).
     * @return bool
     */
    public function actualizarStock(int $productoId, int $cantidad): bool
    {
        $producto = Producto::findOrFail($productoId);
        
        // Verifica si el stock es suficiente antes de restar (solo si es una resta)
        if ($cantidad > 0 && $producto->stock < $cantidad) {
            // Podrías lanzar una excepción personalizada aquí
            throw new \Exception("Stock insuficiente para el producto ID: $productoId");
        }
        
        // Actualiza el stock
        $producto->stock = $producto->stock - $cantidad;
        $producto->save();
        
        return true;
    }
}