<?php

namespace App\Controllers;

use App\Models\Mascotas;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class MascotasController extends Controller
{

    public function Registrar($request, $response, $args) {
        
        $ses_cliente = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        
        $carpeta = "uploads/mascotas/";
        
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
                    Mascotas::where('id_mascota', '=', $codigo)->update([
                        'nombre' => $request->getParam('nombre'),
                        'edad' => $request->getParam('edad'),
                        'descripcion' => $request->getParam('descripcion'),
                        'id_tipomascota' => $request->getParam('id_tipomascota'),
                        'id_cliente' => $ses_cliente,
                        'estado' => $request->getParam('estado'),
                        'foto' => $src
                    ]);
                    $mensaje['response'] = 'success';
                    $mensaje['message'] = 'Registro guardado';
                }
            } else {
                Mascotas::where('id_mascota', '=', $codigo)->update([
                        'nombre' => $request->getParam('nombre'),
                        'edad' => $request->getParam('edad'),
                        'descripcion' => $request->getParam('descripcion'),
                        'id_tipomascota' => $request->getParam('id_tipomascota'),
                        'id_cliente' => $ses_cliente,
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
                
                Mascotas::create([
                        'nombre' => $request->getParam('nombre'),
                        'edad' => $request->getParam('edad'),
                        'descripcion' => $request->getParam('descripcion'),
                        'id_tipomascota' => $request->getParam('id_tipomascota'),
                        'id_cliente' => $ses_cliente,
                        'estado' => $request->getParam('estado'),
                        'foto' => $src
                ]);
                
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
            }
        }
        
        echo json_encode($mensaje);
    }

    public function Editar($request, $response, $args) {
        try {
            $codigo = $request->getParam('codigo');
            $data = Mascotas::where('id_mascota', '=', $codigo)->get();
            return $this->response->withJson($data);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }
    
    
    public function ListarMascotas()
    {
        $ses_cliente = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        return Mascotas::select('tipo_mascota.descripcion as tipo', 'mascota.*')
                ->join('tipo_mascota', 'mascota.id_tipomascota', '=', 'tipo_mascota.id_tipomascota')
                ->where('mascota.id_cliente', $ses_cliente)->where('mascota.estado', '1')->get();
    }
    
}
