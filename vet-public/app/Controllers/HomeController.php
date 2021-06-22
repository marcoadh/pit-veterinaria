<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

Class  HomeController extends Controller
{

    public function index($request, $response)
    {
        return $this->view->render($response, 'home.twig');
    }
    
    public function getViewInscripciones($request, $response)
    {
        return $this->view->render($response, 'templates/inscripciones.twig');
    }
    
    public function getViewRegistro($request, $response)
    {
        return $this->view->render($response, 'templates/registro.twig');
    }
    
    public function getViewDashboard($request, $response)
    {
        return $this->view->render($response, 'templates/dashboard.twig');
    }
    
    
    public function getViewNosotros($request, $response)
    {
        return $this->view->render($response, 'templates/nosotros.twig');
    }
    
      public function getViewResultados($request, $response)
    {
        return $this->view->render($response, 'templates/resultados.twig');
    }
    
      public function getViewIniciativas($request, $response)
    {
        return $this->view->render($response, 'templates/iniciativas.twig');
    }
 
    public function getViewProductos($request, $response)
    {
        return $this->view->render($response, 'templates/productos.twig');
    }
    
    public function getViewServicios($request, $response)
    {
        return $this->view->render($response, 'templates/servicios.twig');
    }
}
