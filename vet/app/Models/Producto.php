<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
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
           'marca',
           'id_proveedor',
           'foto1',
           'estado',
    ];
}
