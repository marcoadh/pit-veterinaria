<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model {

    protected $table = 'detalle_pedido';
    protected $fillable = [
        'id_detallepedido',
        'id_pedido',
        'id_producto_servicio',
        'cantidad',
    ];

}
