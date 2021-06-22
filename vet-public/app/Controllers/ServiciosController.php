<?php

namespace App\Controllers;

use App\Models\Servicios;
use App\Models\Foto;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class ServiciosController extends Controller{

    public function Listar($request, $responde, $args){
        try {
            $data = Servicios::orderBy('id_servicio', 'ASC')->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    
    public function ListarServicios()
    {
        return Servicios::get();
    }
    
}