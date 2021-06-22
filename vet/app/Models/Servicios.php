<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicio';

    protected $fillable = [
        'id_servicio',
        'nombre',
        'detalle',
        'descripcion',
        'precio',
        'fecha_servicio',
        'foto',
        'estado',
    ];
}
