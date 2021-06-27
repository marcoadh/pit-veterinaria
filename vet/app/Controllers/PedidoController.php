<?php

namespace App\Controllers;

use App\Models\Tracking;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Mascotas;
use App\Models\Historia;
use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class PedidoController extends Controller {

    public function getViewPedido($request, $response) {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::select('pedido.*', 'mascota.nombre')
                        ->join('mascota', 'pedido.id_mascota', 'mascota.id_mascota')
                        ->where('pedido.estado', '=', '1')
                        ->where('pedido.id_cliente', $ses_codigo)->first();
        if (!isset($pedido)) {
            return $this->view->render($response, 'templates/dashboard.twig');
        } else {
            return $this->view->render($response, 'templates/pedido.twig', [
                        'pedido' => $pedido,
            ]);
        }
    }

    public function getViewHistorial($request, $response) {
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
        $str_year = $nuevo_numero_str . "-" . date("Y");

        $pedido = Pedido::create([
                    'numero_pedido' => $str_year,
                    'id_vendedor' => 1,
                    'id_cliente' => $ses_codigo,
                    'id_mascota' => $request->getParam('code_mascota'),
                    'estado' => 1,
                    'fecha_emision' => $fecha_emision,
                    'tipo_pedido' => $request->getParam('code_pedido'),
        ]);

        if ($pedido->id) {
            Tracking::create([
                'id_pedido' => $pedido->id,
                'id_vendedor' => 1,
                'id_usuario' => $ses_usuario,
                'fecha_atencion' => $fecha_emision,
                'observacion' => 'Pedido generado',
                'estado' => 1,
            ]);
        } else {
            $mensaje['response'] = 'error';
            $mensaje['message'] = 'Se ha producido un error al generar el pedido';
        }

        $mensaje['response'] = 'success';
        $mensaje['message'] = 'Pedido registrado';

        echo json_encode($mensaje);
    }

    public function pedido() {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();
        return isset($pedido);
    }

    public function PedidosActivos() {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('tipo_pedido', 1)->get();
        return ($pedido);
    }

    public function PedidosActivosServicios() {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('tipo_pedido', 2)->get();
        return ($pedido);
    }

    public function Listar($request, $response, $args) {
        $tipo = $request->getParam('tipo');
        try {
            $data = Pedido::select('pedido.id_pedido',
                            'pedido.numero_pedido',
                            'pedido.tipo_pedido',
                            DB::raw('CONCAT(usuario.nombre," ",usuario.apellido) AS cliente'),
                            'usuario.dni',
                            'documento_pago.total',
                            'pedido.estado')
                    ->join('documento_pago', 'pedido.id_pedido', 'documento_pago.id_pedido')
                    ->join('cliente', 'pedido.id_cliente', 'cliente.id_cliente')
                    ->join('usuario', 'cliente.id_usuario', 'usuario.id_usuario')
                    ->where('pedido.tipo_pedido', $tipo)
                    ->get();
            $arreglo["data"] = $data;
            return $this->response->withJson($arreglo);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    public function getPedido($request, $response, $args)
    {
        $codigo = $args['cod'];
        $pedido = Pedido::where('id_pedido', $codigo)->first();
        
        $cliente = Cliente::select('usuario.*')
                                ->join('usuario', 'cliente.id_usuario', 'usuario.id_usuario')
                                ->where('cliente.id_cliente', $pedido->id_cliente)
                                ->first();
        
        $mascota = Mascotas::select('mascota.*','tipo_mascota.descripcion as tipo')
                                ->join('pedido', 'mascota.id_mascota', 'pedido.id_mascota')
                                ->join('tipo_mascota', 'mascota.id_tipomascota', 'tipo_mascota.id_tipomascota')
                                ->where('pedido.id_pedido', $pedido->id_pedido)
                                ->first();
        
        $historia = Historia::select('historia.*')
                                ->join('mascota', 'historia.id_mascota', 'mascota.id_mascota')
                                ->join('pedido', 'mascota.id_mascota', 'pedido.id_mascota')
                                ->where('pedido.id_pedido', $pedido->id_pedido)
                                ->get();
        
        list($ano,$mes,$dia) = explode("-",$mascota->edad);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($dia_diferencia < 0 && $mes_diferencia <= 0)
        $ano_diferencia--;
  
        return $this->view->render($response, 'admin/auth/pedido-detalle.twig',[
            'pedido' => $pedido,
            'cliente' => $cliente,
            'mascota' => $mascota,
            'tiempo' => $ano_diferencia,
            'historia' => $historia,
        ]);
    }

    public function GetDetallePedido($request, $response, $args) {
        $codigo = $request->getParam('codigo');
        try {
            $data = DetallePedido::select('detalle_pedido.id_producto_servicio','detalle_pedido.cantidad','producto.nombre','producto.precio')
                    ->join('producto','detalle_pedido.id_producto_servicio','producto.id_producto')
                    ->where('id_pedido', '=', $codigo)->get();
            return $this->response->withJson($data);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    public function AtencionFinal($request, $response, $args) {
        $fecha_emision = date("Y-m-d");
        $sessesion = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : '';
                Tracking::create([
                    'id_pedido' => $request->getParam('pedido'),
                    'id_vendedor' => 1,
                    'id_usuario' => $sessesion,
                    'fecha_atencion' => $fecha_emision,
                    'observacion' => $request->getParam('descripcionpedido'),
                    'estado' => 1,
                     ]);
                
                Pedido::where('id_pedido', $request->getParam('pedido'))
                        ->update(['estado' => 3]);
                
                $mensaje['response'] = 'success';
                $mensaje['message'] = 'Registro guardado';
        echo json_encode($mensaje);
    }

}
