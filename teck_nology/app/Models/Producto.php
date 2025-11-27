<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Define la tabla a la que apunta el modelo
    protected $table = 'producto';
    
    // Define la clave primaria (por defecto es 'id')
    protected $primaryKey = 'id_producto';
    
    // Deshabilita los campos 'created_at' y 'updated_at'
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
    ];
}