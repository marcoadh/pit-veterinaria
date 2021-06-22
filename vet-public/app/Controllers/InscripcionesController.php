<?php

namespace App\Controllers;

use App\Models\Inscripciones;
use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class InscripcionesController extends Controller
{

    public function Registrar($request, $response, $args) {
        $codigo = $request->getParam('codigo');
        $estado= $request->getParam('estado');
        if ($codigo) {
            
                 if ($estado == 1) {
                    Inscripciones::where('estado', '=', 1)
                            ->update([
                        'estado' => 2,
                    ]);
                } 
                
                  Inscripciones::where('id_incripcion', '=', $codigo)->update([
                    'tope' => $request->getParam('tope'),
                    'inicio' => $request->getParam('inicio'),
                    'fin' => $request->getParam('fin'),
                    'estado' => $request->getParam('estado'),
                ]);
                  
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro actualizado';
        } else {
            
                    $fecha_actual = date("Y");
                    $anio = (int)$fecha_actual;
                    $ultimocodigo = Inscripciones::select(DB::raw('substr(codigo, 1, 4) as num'))
                        ->where(DB::raw('substr(codigo, 6, 9)'), '=' , $anio)
                        ->orderBy('num', 'DESC')->first();

                    if(!$ultimocodigo){
                        $numero = 0;
                    }else{
                        $numero = $ultimocodigo->num;
                    }

                    $nuevo_numero = $numero + 1 ;
                    $nuevo_numero_str = str_pad($nuevo_numero, 4, "0", STR_PAD_LEFT);
                    $str_year = $nuevo_numero_str."-".date("Y");
                    
                    Inscripciones::create([
                    'codigo' => $str_year,
                    'tope' => $request->getParam('tope'),
                    'inicio' => $request->getParam('inicio'),
                    'fin' => $request->getParam('fin'),
                    'estado' => 2,
                ]);
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';         
        }
        echo json_encode($mensaje);
    }

    public function Listar($request, $response, $args) {
        try {
            $data = Inscripciones::where('estado', '!=', 3)
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
            $data = Inscripciones::where('id_incripcion', '=', $codigo)->get();
            return $this->response->withJson($data, 200);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 200);
        }
    }
    
    public function InscripcionActiva()
    {
        $inscripcion = Inscripciones::where('estado', '1')->first();
        return $inscripcion;
    }
    
    
}
