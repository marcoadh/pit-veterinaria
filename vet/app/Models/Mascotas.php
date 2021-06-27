<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mascotas extends Model
{

    protected $table = 'mascota';
    
    protected $fillable = [
        'id_mascota',
        'nombre',
        'edad',
        'descripcion',
        'id_tipomascota',
        'id_cliente',
        'foto',
        'estado',
    ];
   
    
}