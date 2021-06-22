<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategoria extends Model
{
    protected $table = 'ta_menu_category';

    protected $fillable = [
        'idcategory',
        'nombre',
        'posicion',
    ];
}
