<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{

    protected $table = 'cliente';
    
    protected $fillable = [
        'id_usuario',
        'id_cliente',
    ];
     
}