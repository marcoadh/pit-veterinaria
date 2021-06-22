<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TipoMascota extends Model
{

    protected $table = 'tipo_mascota';
    
    protected $fillable = [
        'id_tipomascota',
        'descripcion',
    ];
   
    
}