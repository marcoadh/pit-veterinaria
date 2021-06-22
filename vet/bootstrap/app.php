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

$container['EdicionController'] = function ($container) {
    return new \App\Controllers\EdicionController($container);
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages;
};

$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[
        'cache' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('ProveedorController', [
        'listaproveedor' => $container->ProveedorController->listarProveedor(),
    ]);
    
  $view->getEnvironment()->addGlobal('flash', $container->flash);
   return $view;
};

$container['EntradaController'] = function ($container) {
    return new \App\Controllers\EntradaController($container);
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

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

$container['MenuItemController'] = function ($container) {
    return new \App\Controllers\MenuItemController($container);
};

$container['ProductoController'] = function ($container) {
    return new \App\Controllers\ProductoController($container);
};

$container['FotoController'] = function ($container) {
    return new \App\Controllers\FotoController($container);
};

$container['ProveedorController'] = function ($container) {
    return new \App\Controllers\ProveedorController($container);
};

$container['ServiciosController'] = function ($container) {
    return new \App\Controllers\ServiciosController($container);
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