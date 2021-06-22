<?php

namespace App\Controllers;

use App\Models\Tracking;
use App\Models\Pedido;
use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class PedidoController extends Controller {

    public function getViewPedido($request, $response)
    {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::select('pedido.*','mascota.nombre')
                      ->join('mascota','pedido.id_mascota','mascota.id_mascota')
                      ->where('pedido.estado', '=', '1')
                      ->where('pedido.id_cliente', $ses_codigo)->first();
        
        
        if (!isset($pedido)) {
            return $this->view->render($response, 'templates/dashboard.twig');
        }else{  
             return $this->view->render($response, 'templates/pedido.twig',[
            'pedido' => $pedido,
            ]);
        }
    }
    
    public function getViewHistorial($request, $response)
    {
        return $this->view->render($response, 'templates/historial.twig');
    }
    
    public function Historial($request, $response, $args) {
        try {
            $codigo = $request->getParam('codigo');
            $data = Tracking::where('id_pedido', '=', $codigo)->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data);
        }
    }
    
    public function Registrar($request, $response, $args) {
        
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $ses_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';

        $fecha_emision = date("Y-m-d");
        $fecha_actual = date("Y");
        $anio = (int) $fecha_actual;
        $ultimocodigo = Pedido::select(DB::raw('substr(numero_pedido, 1, 4) as num'))
                        ->where(DB::raw('substr(numero_pedido, 6, 9)'), '=', $anio)
                        ->where('id_cliente', '=', $ses_codigo)
                        ->orderBy('num', 'DESC')
                        ->first();

        if (!$ultimocodigo) {
            $numero = 0;
        } else {
            $numero = $ultimocodigo->num;
        }

        $nuevo_numero = $numero + 1;
        $nuevo_numero_str = str_pad($nuevo_numero, 4, "0", STR_PAD_LEFT);
        $str_year = $nuevo_numero_str . "-" . date("Y") ;

        $pedido = Pedido::create([
                    'numero_pedido' => $str_year,
                    'id_vendedor' => 1,
                    'id_cliente' => $ses_codigo,
                    'id_mascota' => $request->getParam('code_mascota'),
                    'estado' => 1,
                    'fecha_emision' => $fecha_emision,
                    'tipo_pedido' => $request->getParam('code_pedido'),
        ]);
        
        if($pedido->id){
                    Tracking::create([
                    'id_pedido' => $pedido->id,
                    'id_vendedor' => 1,
                    'id_usuario' => $ses_usuario,
                    'fecha_atencion' => $fecha_emision,
                    'observacion' => 'Pedido generado',
                    'estado' => 1,
                     ]);
        }else{
            $mensaje['response'] = 'error';
            $mensaje['message'] = 'Se ha producido un error al generar el pedido';
        }
        
        $mensaje['response'] = 'success';
        $mensaje['message'] = 'Pedido registrado';

        echo json_encode($mensaje);

    }
    
    public function pedido()
    {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();
        return isset($pedido);
    }
    
    public function PedidosActivos()
    {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('tipo_pedido', 1)->get();
        return ($pedido);
    }
    
    public function PedidosActivosServicios()
    {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('tipo_pedido', 2)->get();
        return ($pedido);
    }
    

}   
