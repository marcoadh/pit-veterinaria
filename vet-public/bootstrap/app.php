<?php

use Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;

session_start();

require __DIR__ . '/../vendor/autoload.php';


$settings = require 'settings.php';
$app = new \Slim\App($settings);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
                    $container->router,
                    $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('AuthController', [
        'check' => $container->AuthController->check(),
        'usuario' => $container->AuthController->usuario(),
    ]);
    
    $view->getEnvironment()->addGlobal('TipoMascotaController', [
        'tipomascota' => $container->TipoMascotaController->ListarTipoMascota(),
    ]);
       
    $view->getEnvironment()->addGlobal('MascotasController', [
        'listamascotas' => $container->MascotasController->ListarMascotas(),
    ]);

    $view->getEnvironment()->addGlobal('ProductosController', [
        'listaproductos' => $container->ProductosController->ListarProductos(),
    ]);

    $view->getEnvironment()->addGlobal('ProveedorController', [
        'listaproveedor' => $container->ProveedorController->listarProveedor(),
    ]);

     // Controlador Servicios
     $view->getEnvironment()->addGlobal('ServiciosController', [
        'listaservicios' => $container->ServiciosController->ListarServicios(),
    ]);

    $view->getEnvironment()->addGlobal('PedidoController', [
        'valpedido' => $container->PedidoController->pedido(),
        'listapedidos' => $container->PedidoController->PedidosActivos(),
        'listapedidosservicios' => $container->PedidoController->PedidosActivosServicios(),
        
    ]);
               

    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};


$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

$container['AdminController'] = function ($container) {
    return new \App\Controllers\AdminController($container);
};

$container['AuthController'] = function ($container) {
    return new \App\Controllers\AuthController($container);
};

$container['MenuCategoriaController'] = function ($container) {
    return new \App\Controllers\MenuCategoriaController($container);
};

$container['MenuItemController'] = function ($container) {
    return new \App\Controllers\MenuItemController($container);
};

$container['ExportController'] = function ($container) {
    return new \App\Controllers\ExportController($container);
};

$container['InscripcionesController'] = function ($container) {
    return new \App\Controllers\InscripcionesController($container);
};

$container['UsuariosController'] = function ($container) {
    return new \App\Controllers\UsuariosController($container);
};

$container['TipoMascotaController'] = function ($container) {
    return new \App\Controllers\TipoMascotaController($container);
};

$container['MascotasController'] = function ($container) {
    return new \App\Controllers\MascotasController($container);
};

$container['ProductosController'] = function ($container) {
    return new \App\Controllers\ProductosController($container);
};

$container['ProveedorController'] = function ($container) {
    return new \App\Controllers\ProveedorController($container);
};

$container['FotoController'] = function ($container) {
    return new \App\Controllers\FotoController($container);
};

$container['ServiciosController'] = function ($container) {
    return new \App\Controllers\ServiciosController($container);
};

$container['PedidoController'] = function ($container) {
    return new \App\Controllers\PedidoController($container);
};

$container['DetallePedidoController'] = function ($container) {
    return new \App\Controllers\DetallePedidoController($container);
};

$container['PagoController'] = function ($container) {
    return new \App\Controllers\PagoController($container);
};

$container['HistoriaController'] = function ($container) {
    return new \App\Controllers\HistoriaController($container);
};

$container['csrf'] = function ($container) {
    // return new \Slim\Csrf\Guard;
    $guard = new \Slim\Csrf\Guard();
    $guard->setPersistentTokenMode(true);
    return $guard;
};




$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);


require __DIR__ . '/../app/routes.php';
