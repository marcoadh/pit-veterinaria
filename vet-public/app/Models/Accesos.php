<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   Accesos extends Model
{
    protected $table = 'ta_accesos';

    protected $fillable = [
        'idacceso',
        'iditemenu',
        'iduser',
        'nuevo',
        'editar',
        'eliminar',
        'check',
    ];
}
