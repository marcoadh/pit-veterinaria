<?php

namespace App\Controllers;

use App\Controllers;
use App\Models\Usuarios;
use App\Models\Clientes;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class UsuariosController extends Controller {

    public function Registrar($request, $response, $args) {
        try {
            
              $registrado = Usuarios::where('dni', $request->getParam('dni'))->first();
            
            if($registrado){
                      $msm['response'] = "existe";
                 echo json_encode($msm);
            }else{
            $usuario = Usuarios::create([
                            'dni' => $request->getParam('dni'),
                            'nombre' => $request->getParam('nombres'),
                            'apellido' => $request->getParam('apellidos'),
                            'id_distrito' => $request->getParam('distrito'),
                            'celular' => $request->getParam('tel'),
                            'correo' => $request->getParam('email'),
                            'login' => $request->getParam('dni'),
                            'direccion' => $request->getParam('direccion'),
                            'foto' => $request->getParam('foto'),
                            'id_tipousuario' => 3,
                            'password' => password_hash($request->getParam('clave'), PASSWORD_DEFAULT)
                        ])->id;
                $usuario = Clientes::create([
                            'id_usuario' => $usuario,
                ]);
                $msm['response'] = "exito";
                echo json_encode($msm);
            }
        } catch (ErrorException $e) {
            $msm['response'] = "error";
            echo json_encode($msm);
        }
    }

    public function Listar($request, $response, $args) {
        try {
            $data = Voluntarios::where('estado', '!=', 3)
                            ->orderBy('created_at', 'DESC')->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }

    public function Editar($request, $response, $args) {
        try {
            $codigo = $request->getParam('codigo');
            $data = Voluntarios::where('id_voluntario', '=', $codigo)->get();
            return $this->response->withJson($data, 200);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }

}
