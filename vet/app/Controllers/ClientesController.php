<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;

Class ClienteController extends Controller {


    public function Listar($request, $response, $args) {
        try {
            $data = Cliente::orderBy('id_cliente', 'ASC')->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    

}
