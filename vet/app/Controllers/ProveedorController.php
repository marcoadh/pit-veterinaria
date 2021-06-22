<?php

namespace App\Controllers;

use App\Models\Proveedor;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class ProveedorController extends Controller {

    public function listarProveedor()
    {
        return Proveedor::where('estado', '1')->get();
    }

}
