<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{

    protected $table = 'tracking';
    
    protected $fillable = [
            'id_tracking',
            'id_pedido',
            'id_usuario',
            'fecha_atencion',
            'observacion',
            'estado',
    ];
     
}