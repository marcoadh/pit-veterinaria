<?php

namespace App\Controllers;

use App\Models\Foto;
use App\Models\Galeria;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class FotoController extends Controller {

    
    public function Registrar($request, $response, $args) {
        $carpeta = "uploads/fotos/";
        $nombre = basename($_FILES["fotoproducto"]["name"]);
        $fecha_actual = date('Y-m-d-H-i-s');
        $src = $carpeta . $fecha_actual . '_' . $nombre;
        $tipo = basename($_FILES["fotoproducto"]["type"]);
        $size = basename($_FILES["fotoproducto"]["size"]);
        $moveee = $_FILES["fotoproducto"]["tmp_name"];

        $codigo = $request->getParam('cod');

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
                    Foto::where('id_foto', '=', $codigo)->update([
                        'id_producto' => $request->getParam('codigoproducto'),
                        'foto' => $src,
                        'estado' => $request->getParam('estadofoto'),
                    ]);
                    $mensaje['response'] = 'success';
                    $mensaje['message'] = 'Registro guardado';
                }
            } else {
                Foto::where('id_foto', '=', $codigo)->update([
                    'id_producto' => $request->getParam('codigoproducto'),
                    'estado' => $request->getParam('estadofoto'),
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
                Foto::create([
                    'id_producto' => $request->getParam('codigoproducto'),
                    'foto' => $src,
                    'estado' => $request->getParam('estadofoto'),
                ]);
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
            }
        }
        echo json_encode($mensaje);
    }

    public function Listar($request, $response, $args) {
        try {
            $codigo = $request->getParam('codigo');
            $data = Foto::where('id_producto', '=', $codigo)
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
            $data = Foto::where('id_foto', '=', $codigo)->get();
            return $this->response->withJson($data, 200);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }

}
