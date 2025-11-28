<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    // Relación uno a muchos con Producto
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}
