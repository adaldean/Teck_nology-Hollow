<?php
namespace app\Models;
use Illuminate\Database\Eloquent\Model;
class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
    ];
}