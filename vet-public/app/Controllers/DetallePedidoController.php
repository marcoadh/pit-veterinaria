<?php

namespace App\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class DetallePedidoController extends Controller
{

    public function Registrar($request, $response, $args) {
        
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();
        $producto = $request->getParam('codigo');
        
        
        $ultimoproducto = DetallePedido::select('cantidad')
                        ->where('id_pedido', '=', $pedido->id_pedido)
                        ->where('id_producto_servicio', '=', $producto)
                        ->first();
        
        if ($ultimoproducto) {   

            $numero = $ultimoproducto->cantidad;
            $nuevo_numero = $numero + 1;
            DetallePedido::where('id_producto_servicio', '=', $producto)
                    ->where('id_pedido', '=', $pedido->id_pedido)
                    ->update([
                        'cantidad' => $nuevo_numero,
            ]);
            $mensaje['response'] = 'success';
            $mensaje['message'] = 'Producto agregado upd';
            
        } else {
            
            DetallePedido::create([
                'id_pedido' => $pedido->id_pedido,
                'id_producto_servicio' => $producto,
                'cantidad' => 1,
            ]);

            $mensaje['response'] = 'success';
            $mensaje['message'] = $pedido   ;
        
        }

        echo json_encode($mensaje);
    }

    public function GetDetalle($request, $response, $args) {
        try {
            
            $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
            $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();

            $data = DetallePedido::select('detalle_pedido.id_producto_servicio','detalle_pedido.cantidad','producto.nombre','producto.precio')
                    ->join('producto','detalle_pedido.id_producto_servicio','producto.id_producto')
                    ->where('id_pedido', '=', $pedido->id_pedido)->get();

            //$arreglo["data"] = $data;
            return $this->response->withJson($data);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    public function GetDetalleServicio($request, $response, $args) {
        try {
            
            $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
            $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();

            $data = DetallePedido::select('detalle_pedido.id_producto_servicio','detalle_pedido.cantidad','servicio.nombre','servicio.precio')
                    ->join('servicio','detalle_pedido.id_producto_servicio','servicio.id_servicio')
                    ->where('id_pedido', '=', $pedido->id_pedido)->get();
            return $this->response->withJson($data);
        } catch (ErrorException $e) {
            $data = "Hubo un error al listar los datos.";
            return $this->response->withJson($data, 500);
        }
    }
    
    
        public function Reducir($request, $response, $args) {
        
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();
        $producto = $request->getParam('codigo');
        
        
        $ultimoproducto = DetallePedido::select('cantidad')
                        ->where('id_pedido', '=', $pedido->id_pedido)
                        ->where('id_producto_servicio', '=', $producto)
                        ->first();
         $numero = $ultimoproducto->cantidad;
         
        if ($numero > 1) {   

            $numero = $ultimoproducto->cantidad;
            $nuevo_numero = $numero - 1;
            DetallePedido::where('id_producto_servicio', '=', $producto)
                    ->where('id_pedido', '=', $pedido->id_pedido)
                    ->update([
                        'cantidad' => $nuevo_numero,
            ]);
            $mensaje['response'] = 'success';
            $mensaje['message'] = 'Producto agregado';
            
        } else {

            DetallePedido::
                    where('id_producto_servicio', '=', $producto)
                    ->where('id_pedido', '=', $pedido->id_pedido)
                    ->delete();

            $mensaje['response'] = 'success';
            $mensaje['message'] = 'Producto agregado';
        
        }

        echo json_encode($mensaje);
    }

 
    
}
