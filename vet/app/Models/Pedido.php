<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    protected $table = 'pedido';
    
    protected $fillable = [
        'id_pedido',
        'numero_pedido',
        'id_vendedor',
        'id_cliente',
        'id_mascota',
        'estado',
        'fecha_emision',
        'tipo_pedido',
    ];
     
}