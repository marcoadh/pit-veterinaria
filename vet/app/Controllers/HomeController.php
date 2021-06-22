<?php

namespace App\Controllers;

use App\Models\Edicion;
use Slim\Views\Twig as View;

Class HomeController extends Controller {

    public function index($request, $response) {
        return $this->view->render($response, 'home.twig');
    }

    public function quienessomos($request, $response) {
        return $this->view->render($response, 'templates/quienessomos.twig');
    }
    
    public function historia($request, $response) {
        return $this->view->render($response, 'templates/historia.twig');
    }
    
      public function filiales($request, $response) {
        return $this->view->render($response, 'templates/filiales.twig');
    }
    
    public function comopublicar($request, $response) {
        return $this->view->render($response, 'templates/comopublicar.twig');
    }
    
    public function contacto($request, $response) {
        return $this->view->render($response, 'templates/contacto.twig');
    }
    
    public function librerias($request, $response) {
        return $this->view->render($response, 'templates/librerias.twig');
    }
    
    public function libreriablancavarela($request, $response) {
        return $this->view->render($response, 'templates/libreriablancavarela.twig');
    }
    
    public function libreriaunmsm($request, $response) {
        return $this->view->render($response, 'templates/libreriaunmsm.twig');
    }
    
    public function catalogo($request, $response) {
        return $this->view->render($response, 'templates/catalogo.twig');
    }
    
    public function talleres($request, $response) {
        return $this->view->render($response, 'templates/talleres.twig');
    }
    
    public function concursos($request, $response) {
        return $this->view->render($response, 'templates/concursos.twig');
    }
    
    public function lecturas($request, $response) {       
         $total = Edicion::sum('descargas');
          return $this->view->render($response, 'templates/lecturas.twig',[
            'total' => $total,
        ]);
          
    }
    
    public function publicaciones($request, $response) {
        return $this->view->render($response, 'templates/publicaciones.twig');
    }
    
    public function galeria($request, $response) {
        return $this->view->render($response, 'templates/galeria.twig');
    }
        
    public function noticias($request, $response) {
        return $this->view->render($response, 'templates/noticias.twig');
    }
    
    public function servicios($request, $response) {
        return $this->view->render($response, 'templates/servicios.twig');
    }
    
    public function servicio($request, $response) {
        return $this->view->render($response, 'templates/servicio.twig');
    }
    
    
    public function productos($request, $response) {
        return $this->view->render($response, 'templates/productos.twig');
    }
    
    public function encuestas($request, $response) {
        return $this->view->render($response, 'templates/encuestas.twig');
    }
    
    public function getViewProducto($request, $response) {
        return $this->view->render($response, 'templates/producto.twig');
    }
    
    public function venta($request, $response) {
        return $this->view->render($response, 'templates/venta.twig');
    }
    
    
}
