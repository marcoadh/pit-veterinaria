<?php
namespace App\Controllers;
use App\Helper\JsonRequest;
use App\Helper\JsonRenderer;

use App\Models\Accesos;
use App\Models\MenuItem;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
Class MenuItemController extends Controller
{

    public function getMenuItem($request, $response, $args)
    {
        try {
            $ses_codigo = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : '';
            $codigo = $request->getParam('codigo');
            $data = Accesos::select('ta_menu_item.iditem', 'ta_accesos.idacceso','ta_accesos.iduser',
                'ta_menu_item.iditem' , 'ta_menu_item.idcategory', 'ta_menu_item.nombre', 'ta_menu_item.tag' )
                ->join('ta_menu_item', 'ta_accesos.iditemenu', '=', 'ta_menu_item.iditem')
                ->where('ta_menu_item.idcategory', $codigo)
                ->where('ta_accesos.iduser', $ses_codigo)
                ->GroupBy('ta_menu_item.nombre')
                ->orderBy('ta_menu_item.iditem')->get();
            $arreglo["data"] = $data;
            return json_encode($arreglo);

        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }


    }

}
