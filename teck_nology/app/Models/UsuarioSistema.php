<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class UsuarioSistema extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario_sistema';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'email',
        'contrasena', 
        'id_rol',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // 5. Ocultar atributos sensibles al serializar (por ejemplo, al devolver JSON)
    protected $hidden = [
        'contrasena',
    ];

}