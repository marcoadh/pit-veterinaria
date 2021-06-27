<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->group('', function () {
    $this->get('/', 'HomeController:index')->setName('home');
    $this->post('/usuario/registrar', 'UsuariosController:Registrar');
    $this->get('/registro', 'HomeController:getViewInscripciones')->setName('registro');
    $this->get('/login', 'AuthController:getSignIn')->setName('login');
    $this->post('/login', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function () {
    $this->get('/bienvenido', 'HomeController:getViewDashboard')->setName('dashboard');
    $this->get('/nosotros', 'HomeController:getViewNosotros')->setName('nosotros');
    
    $this->get('/pedido', 'PedidoController:getViewPedido')->setName('pedido');
    $this->get('/historial', 'PedidoController:getViewHistorial')->setName('historial');
    
    $this->post('/pedido/registrar', 'PedidoController:Registrar');     
    
    //////MARCO//////
    $this->get('/productos', 'HomeController:getViewProductos')->setName('productos');
    $this->get('/servicios', 'HomeController:getViewServicios')->setName('servicios');
    //////MARCO//////
    
    $this->get('/resultados', 'HomeController:getViewResultados')->setName('resultados');
    $this->get('/signout', 'AuthController:getSignOut')->setName('auth.signout');
    $this->post('/mascota/registrar', 'MascotasController:Registrar');
    $this->get('/mascota/editar', 'MascotasController:Editar');
    $this->get('/detalle/registrar', 'DetallePedidoController:Registrar');
    $this->get('/detalle/listar', 'DetallePedidoController:GetDetalle');
     $this->get('/detalle/listarservicio', 'DetallePedidoController:GetDetalleServicio');   
    $this->get('/detalle/reducir', 'DetallePedidoController:Reducir');
    
     $this->get('/pedido/pagar', 'PagoController:Registrar');
     $this->get('/pedido/historial', 'PedidoController:Historial');

     $this->get('/historial/mascota', 'HistoriaController:Historial');
        
})->add(new AuthMiddleware($container));
