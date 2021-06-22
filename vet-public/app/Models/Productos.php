<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{

    protected $table = 'producto';
    
    protected $fillable = [
        'id_producto',
        'nombre',
        'descripcion',
        'descripcion_html',
        'precio',
        'unimed',
        'stock_act',
        'serie',
        'id_proveedor',
        'foto1',
        'estado',
    ];
   
    
}