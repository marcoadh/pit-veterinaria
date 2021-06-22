<?php

namespace App\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use App\Models\Tracking;
use App\Models\DetallePedido;
use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class PagoController extends Controller {

    public function Registrar($request, $response, $args) {
         try {
        $ses_codigo = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : '';
        $ses_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';

        $pedido = Pedido::where('id_cliente', $ses_codigo)->where('estado', '=', '1')->first();
        $fecha_emision = date("Y-m-d"); 
        $total = DetallePedido::
                 join('producto','detalle_pedido.id_producto_servicio','producto.id_producto')
                ->where('id_pedido', '=', $pedido->id_pedido)
                ->sum(DB::raw('detalle_pedido.cantidad * producto.precio'));
        
           $transaccion =  Pago::create([
                'id_vendedor' => 1, //Usuario (1) es vendedor internet
                'id_pedido' => $pedido->id_pedido,
                'total' => $total,
                'fecha' => $fecha_emision,
                'id_tipodocumento' =>1, //Documento de tipo factura por defecto
            ]);
           
           if($transaccion->id){
                    Pedido::
                    where('id_pedido', '=', $pedido->id_pedido)
                    ->update([ 'estado' => 2 ]);
                    
                      Tracking::create([
                        'id_pedido' => $pedido->id_pedido,
                        'id_vendedor' => 1,
                        'id_usuario' => $ses_usuario,
                        'fecha_atencion' => $fecha_emision,
                        'observacion' => 'Pago realizado',
                        'estado' => 1,
                         ]);
                      
           }else{
            $mensaje['response'] = 'error';   
            $mensaje['message'] = 'Se ha producido un error al realizar el pago';
           }
                
            $mensaje['response'] = 'success';   
            $mensaje['message'] = 'Pago exitoso';
        } catch (ErrorException $e) {
            $mensaje['response'] = 'error';   
            $mensaje['message'] = 'Se ha producido un error, actualice la página';
        }
        echo json_encode($mensaje);

    }
    
}   
