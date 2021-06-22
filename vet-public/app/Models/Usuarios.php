<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
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
        'foto',
        'estado',
    ];
     
}