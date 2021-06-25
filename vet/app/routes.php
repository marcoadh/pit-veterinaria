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
    
    $this->get('/formulario', 'AdminController:getformulario')->setName('admin.formulario');
    $this->get('/formulario/listar', 'FormularioController:Listar');
    $this->post('/formulario/registrar', 'FormularioController:Registrar');
    $this->get('/formulario/editar', 'FormularioController:Editar');
    $this->post('/formulario/atender', 'FormularioController:Atender');
    
    $this->get('/encuestas', 'AdminController:getEncuesta')->setName('admin.encuestas');
    $this->get('/encuestas/listar', 'EncuestaController:Listar');
    $this->post('/encuestas/registrar', 'EncuestaController:Registrar');
    $this->get('/encuestas/editar', 'EncuestaController:Editar');
    $this->post('/encuestas/atender', 'EncuestaController:Atender');
    
     $this->get('/preguntas/listaporcuestionario', 'PreguntaController:getPreguntasPorEncuesta');
     $this->post('/preguntas/registrar', 'PreguntaController:Registrar');
    $this->get('/preguntas/editar', 'PreguntaController:getPregunta');
     
     $this->get('/respuestas/export/{cod}', 'ExportController:Preguntas');
        
    $this->get('/suscripciones', 'AdminController:getsuscripciones')->setName('admin.suscripciones');

    $this->get('/actualidad', 'AdminController:getActualidad')->setName('admin.actualidad');

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
    
     $this->get('/suscripciones/listar', 'SuscripcionController:Listar');

    
})->add(new AuthMiddleware($container));

//PUBLICO 


$app->get('/', 'HomeController:index')->setName('home');
$app->get('/contacto', 'HomeController:contacto')->setName('contacto');

$app->get('/nosotros', 'HomeController:quienessomos')->setName('nosotros');

$app->get('/noticias', 'HomeController:noticias')->setName('noticias');
$app->get('/noticia/{cod}', 'EntradaController:getViewEntrada')->setName('noticia');

$app->get('/servicios', 'HomeController:servicios')->setName('servicios');
$app->get('/servicio/{cod}', 'EntradaController:getViewServicio')->setName('servicio');

$app->get('/productos', 'HomeController:productos')->setName('productos');
$app->get('/producto/{cod}', 'ProductoController:getViewProducto')->setName('producto');

$app->get('/encuestas', 'HomeController:encuestas')->setName('encuestas');

$app->get('/servicio', 'HomeController:servicio')->setName('servicio');

$app->post('/formulario/registrar', 'FormularioController:Registrar');
$app->post('/respuesta/registrar', 'RespuestaController:Registrar');
$app->post('/suscripcion/registrar', 'SuscripcionController:Registrar');



$app->get('/galeria', 'HomeController:galeria')->setName('galeria');
$app->get('/fotos/{cod}', 'FotoController:getViewFotos')->setName('fotos');


 
