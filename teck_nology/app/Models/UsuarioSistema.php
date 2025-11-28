<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// El nombre del modelo debe ser singular y, por convención, coincidir con el nombre de la tabla
// (aunque aquí forzamos el nombre de la tabla)
class UsuarioSistema extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Especificar el nombre de la tabla
    protected $table = 'usuario_sistema';

    // 2. Especificar la clave primaria si no se llama 'id'
    protected $primaryKey = 'id_usuario';

    // 3. Especificar qué campos se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'email',
        'contrasena', // ¡Importante! Este campo debe estar presente
        'id_rol',
    ];

    // 4. Mapeo de campos de autenticación (Necesario para Laravel Auth)
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // 5. Ocultar atributos sensibles al serializar (por ejemplo, al devolver JSON)
    protected $hidden = [
        'contrasena',
    ];

    // 6. Si usas timestamps (created_at, updated_at), déjalo en true.
    // Si tu tabla no los tiene, configúralo en false.
    public $timestamps = false;
}