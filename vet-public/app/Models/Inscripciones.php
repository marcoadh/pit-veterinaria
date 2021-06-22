<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Inscripciones extends Model
{

    protected $table = 'tb_inscripciones';
    
    protected $fillable = [
        'id_incripcion',
        'codigo',
        'tope',
        'inicio',
        'fin',
        'estado'
    ];
   
    
}