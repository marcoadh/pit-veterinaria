<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $table = 'veterinario';

    protected $fillable = [
        'id_veterinario',
        'codigo_veterinario',
        'id_usuario',
        'id_especialidad',
    ];
}
