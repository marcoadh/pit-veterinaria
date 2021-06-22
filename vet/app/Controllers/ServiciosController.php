<?php

namespace App\Controllers;

use App\Models\Servicios;
use App\Models\Foto;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;

Class ServiciosController extends Controller {

    public function Registrar($request, $response, $args) {
        $carpeta = "uploads/productos/";
        $nombre = basename($_FILES["foto"]["name"]);
        $fecha_actual = date('Y-m-d-H-i-s');
        $src = $carpeta . $fecha_actual . '_' . $nombre;
        $tipo = basename($_FILES["foto"]["type"]);
        $size = basename($_FILES["foto"]["size"]);
        $moveee = $_FILES["foto"]["tmp_name"];
        $codigo = $request->getParam('codigo');

        if ($codigo) {
            if ($nombre) {
                if ($tipo != 'png' and
                        $tipo != 'jpg' and
                        $tipo != 'jpeg') {
                    $mensaje['response'] = 'error';
                    $mensaje['message'] = 'Solo se permiten archivos JPG, JPEG o PNG.';
                } elseif ($size >= 262144000) {
                    $mensaje['response'] = 'error';
                    $mensaje['message'] = 'Solo se permiten subir imágenes de menos de 25 Megabytes.';
                } elseif (move_uploaded_file($moveee, $src)) {
                    Servicios::where('id_servicio', '=', $codigo)->update([
                        'nombre' => $request->getParam('nombre'),
                        'detalle' => $request->getParam('detalle'),
                        'descripcion' => $request->getParam('descripcion'),
                        'precio' => $request->getParam('precio'),
                        'estado' => $request->getParam('estado'),
                        'foto' => $src,
                    ]);
                    $mensaje['response'] = 'success';
                    $mensaje['message'] = 'Registro guardado';
                }
            } else {
                Servicios::where('id_servicio', '=', $codigo)->update([
                         'nombre' => $request->getParam('nombre'),
                        'detalle' => $request->getParam('detalle'),
                        'descripcion' => $request->getParam('descripcion'),
                        'precio' => $request->getParam('precio'),
                        'estado' => $request->getParam('estado'),
                        'estado' => $request->getParam('estado'),
                ]);
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
            }
        } else {

            if ($tipo != 'png' and
                    $tipo != 'jpg' and
                    $tipo != 'jpeg') {
                $mensaje['response'] = 'error';
                $mensaje['message'] = 'Solo se permiten archivos JPG, JPEG o PNG.';
            } elseif ($size >= 262144000) {
                $mensaje['response'] = 'error';
                $mensaje['message'] = 'Solo se permiten subir imágenes de menos de 25 Megabytes.';
            } elseif (move_uploaded_file($moveee, $src)) {
                Servicios::create([
                        'nombre' => $request->getParam('nombre'),
                        'detalle' => $request->getParam('detalle'),
                        'descripcion' => $request->getParam('descripcion'),
                        'precio' => $request->getParam('precio'),
                        'estado' => $request->getParam('estado'),
                        'foto' => $src,
                ]);
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
            }
        }
        echo json_encode($mensaje);
    }


    public function Listar($request, $response, $args) {
        try {
            $data = Servicios::orderBy('id_servicio', 'ASC')->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    
    public function getProducto($request, $response, $args) {
        try {
            $codigo = $request->getParam('codigo');
            $data = Servicios::where('id_servicio', '=', $codigo)->get();
            return $this->response->withJson($data, 200);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }
    

}
