<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';

    protected $fillable = [
        'id_foto',
        'id_producto',
        'foto',
        'estado'
    ];
}
