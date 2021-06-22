<?php
namespace App\Controllers;
use App\Helper\JsonRequest;
use App\Helper\JsonRenderer;

use App\Models\Documentos;
use App\Models\MenuCategoria;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Capsule\Manager as DB;

Class MenuCategoriaController extends Controller
{

    public function getMenuCategory($request, $response, $args)
    {

        try {
            $data = MenuCategoria::get();
            $arreglo["data"] = $data;
            return json_encode($arreglo);

        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }


}
