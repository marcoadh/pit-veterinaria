<?php

namespace App\Controllers;

use App\Models\Historia;
use App\Models\Veterinario;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;

Class HistoriaController extends Controller {

    public function Registrar($request, $response, $args) {
        $sessesion = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : '';
        $veterinario = Veterinario::where('id_usuario', $sessesion)->first();
                Historia::create([
                        'id_veterinario' => $veterinario->id_veterinario,
                        'id_mascota' => $request->getParam('mascota'),
                        'incidencia' => $request->getParam('descripcion'),
                ]);
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
        echo json_encode($mensaje);
    }

}
