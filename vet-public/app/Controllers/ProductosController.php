<?php
namespace App\Controllers;
use App\Models\Productos;
use App\Models\Foto;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

    Class ProductosController extends Controller {

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
                        Productos::where('id_producto', '=', $codigo)->update([
                            'nombre' => $request->getParam('nombre'),
                            'descripcion' => $request->getParam('detalle'),
                            'descripcion_html' => $request->getParam('descripcion'),
                            'precio' => $request->getParam('precio'),
                            'unimed' => $request->getParam('unimed'),
                            'stock_act' => $request->getParam('stock_act'),
                            'serie' => $request->getParam('serie'),
                            'id_proveedor' => $request->getParam('id_proveedor'),
                            'estado' => $request->getParam('estado'),
                            'foto1' => $src,
                        ]);
                        $mensaje['response'] = 'success';
                        $mensaje['message'] = 'Registro guardado';
                    }
                } else {
                    Productos::where('id_producto', '=', $codigo)->update([
                            'nombre' => $request->getParam('nombre'),
                            'descripcion' => $request->getParam('detalle'),
                            'descripcion_html' => $request->getParam('descripcion'),
                            'precio' => $request->getParam('precio'),
                            'unimed' => $request->getParam('unimed'),
                            'stock_act' => $request->getParam('stock_act'),
                            'serie' => $request->getParam('serie'),
                            'id_proveedor' => $request->getParam('id_proveedor'),
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
                    Productos::create([
                            'nombre' => $request->getParam('nombre'),
                            'descripcion' => $request->getParam('detalle'),
                            'descripcion_html' => $request->getParam('descripcion'),
                            'precio' => $request->getParam('precio'),
                            'unimed' => $request->getParam('unimed'),
                            'stock_act' => $request->getParam('stock_act'),
                            'serie' => $request->getParam('serie'),
                            'id_proveedor' => $request->getParam('id_proveedor'),
                            'estado' => $request->getParam('estado'),
                            'foto1' => $src,
                    ]);
                    $mensaje['response'] = 'success';
                    $mensaje['message'] = 'Registro guardado';
                }
            }
            echo json_encode($mensaje);
        }
    
    
        public function Listar($request, $response, $args) {
            try {
                $data = Productos::orderBy('id_producto', 'ASC')->get();
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
                $data = Productos::where('id_producto', '=', $codigo)->get();
                return $this->response->withJson($data, 200);
            } catch (ErrorException $e) {
                $data = "Hubo un error al listar los datos.";
                return $this->response->withJson($data, 200);
            }
        }
        
         public function  getViewProducto($request, $response, $args) {
            $codigo = $args['cod'];
            $producto = Productos::where('codigo', '=', $codigo)->where('estado', '=', 1)->first();
            $otros = Productos::where('codigo', '=', $codigo)->where('estado', '=', 1)->get();
            $fotos = Foto::where('cod_producto', '=', $codigo)->where('estado', '=', 1)->get();
            return $this->view->render($response, 'templates/productos.twig',[
                'producto' => $producto,
                'otros' => $otros,
                'fotos' => $fotos,
            ]);
        }
        
        public function ListarProductos()    
        {
            return Productos::select('producto.*','proveedor.descripcion as desc')
                    ->join('proveedor', 'producto.id_proveedor', '=', 'proveedor.id_proveedor')->where('producto.estado', '1')->get();
        }
        
    
    }
    