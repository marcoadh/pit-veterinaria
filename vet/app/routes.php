<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->group('', function () {
    $this->get('/admin/auth', 'AdminController:getViewDashSignIn')->setName('admin.signin');
    $this->post('/admin/auth', 'AdminController:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('/admin', function () {
    $this->get('/listamenu', 'MenuCategoriaController:getMenuCategory');
    $this->get('/dash', 'AdminController:getViewDash')->setName('admin.dash');
    $this->get('/listaitem', 'MenuItemController:getMenuItem');
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    
    $this->get('/productos', 'AdminController:getProductos')->setName('admin.productos');
    $this->get('/productos/listar', 'ProductoController:Listar');
    $this->post('/productos/registrar', 'ProductoController:Registrar');
    $this->get('/productos/editar', 'ProductoController:getProducto');
    
    $this->get('/servicios', 'AdminController:getServicios')->setName('admin.servicios');
    $this->get('/servicios/listar', 'ServiciosController:Listar');
    $this->post('/servicios/registrar', 'ServiciosController:Registrar');
    $this->get('/servicios/editar', 'ServiciosController:getProducto');

    $this->get('/clientes', 'AdminController:getClientes')->setName('admin.clientes');
    $this->get('/clientes/listar', 'ClienteController:Listar');
    
    $this->get('/foto/listar', 'FotoController:Listar');
    $this->post('/foto/registrar', 'FotoController:Registrar');
    $this->get('/foto/editar', 'FotoController:Editar');

    $this->get('/entrada/editar', 'EntradaController:getEntrada');
    $this->get('/listaentrada', 'EntradaController:Listar');
    $this->post('/registrarentrada', 'EntradaController:Registrar');
    
    $this->get('/pedidos-productos', 'AdminController:getPedidosProductos')->setName('admin.pedidosproductos');
    $this->get('/pedidos-servicios', 'AdminController:getPedidosServicios')->setName('admin.pedidosservicios');
    $this->get('/pedidos/listar', 'PedidoController:Listar');
    $this->post('/pedidos/registrar', 'PedidoController:Registrar');
    $this->get('/pedidos/editar', 'PedidoController:getPedido');
    
    $this->get('/detalle/listar', 'PedidoController:GetDetallePedido');
        
    $this->get('/pedido/{cod}', 'PedidoController:getPedido')->setName('admin.pedido');
    $this->post('/historia/registrar', 'HistoriaController:Registrar');
    $this->post('/pedido/actualizar', 'PedidoController:AtencionFinal');
        
})->add(new AuthMiddleware($container));

//PUBLICO 


$app->get('/', 'HomeController:index')->setName('home');