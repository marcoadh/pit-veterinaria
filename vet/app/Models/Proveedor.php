<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';

    protected $fillable = [
            'id_proveedor',
            'ruc',
            'razonsocial',
            'descripcion',
            'direccion',
            'telefono',
            'correo',
            'id_distrito',
            'estado',
    ];
}
