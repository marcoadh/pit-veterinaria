<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historia';

    protected $fillable = [
    'id_historia',
    'id_mascota',
    'id_veterinario',
    'incidencia',
    'estado',
    ];
}
