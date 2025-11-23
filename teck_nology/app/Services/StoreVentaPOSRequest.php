// app/Http/Requests/StoreVentaPOSRequest.php

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaPOSRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Verifica si el usuario actual (empleado) tiene permiso para realizar ventas.
        // Asumimos que la autenticación ya está configurada.
        return true; 
    }

    public function rules(): array
    {
        return [
            // Validación de los campos principales
            'id_empleado' => 'required|integer|exists:empleado,id_empleado',
            'id_tienda'   => 'required|integer|exists:tienda,id_tienda',
            'id_cliente'  => 'nullable|integer|exists:cliente,id_cliente', // Opcional para lealtad
            
            // Validación de los detalles de la venta (debe ser un array)
            'detalles' => 'required|array|min:1', 
            
            // Validación de cada elemento dentro del array 'detalles'
            'detalles.*.id_producto' => 'required|integer|exists:producto,id_producto',
            'detalles.*.cantidad'    => 'required|integer|min:1',
            // No validamos 'precio' aquí, ya que el servicio lo toma del modelo Producto para seguridad.
        ];
    }
    
    // Opcional: Personalizar mensajes de error
    public function messages()
    {
        return [
            'detalles.min' => 'La venta debe contener al menos un producto.',
        ];
    }
}