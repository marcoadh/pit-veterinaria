<?php

namespace App\Controllers;

use App\Models\TipoMascota;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class TipoMascotaController extends Controller
{

    public function ListarTipoMascota()
    {
        return TipoMascota::where('estado', '1')->get();
    }
    
   
    
}
