<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'usuario';

    protected $fillable = [
            'id_usuario',
            'dni',
            'nombre',
            'apellido',
            'login',
            'password',
            'celular',
            'correo',
            'direccion',
            'id_distrito',
            'id_tipousuario',
    ];
}
