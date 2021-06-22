<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Controllers\Controller;
use App\Models\Asesorias;
use App\Models\Constataciones;
use App\Models\DetalleReconocimiento;
use App\Models\Documentos;
use App\Models\Reconocimiento;
use App\Models\Resolucion;
use App\Models\Solicitudes;
use App\Models\Usuarios;
use App\Models\Verificacion;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class AdminController extends Controller
{

    
    public function admin()
    {
        $ses_codigo = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : '';
        $admin = Admin::where('codigo', $ses_codigo)->first();
        return $admin;
    }

    public function getViewDash($request, $response)
    {
        return $this->view->render($response, 'admin/dash.twig');
    }


    public function getInscripciones($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/inscripciones.twig');
    }
    
    public function getGrupos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/grupos.twig');
    }
    
    public function getHorarios($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/horarios.twig');
    }
        
    public function getIniciativas($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/iniciativas.twig');
    }
    
     public function getTareas($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/tareas.twig');
    }
    
    public function getEntradaReportes($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/reportes.twig');
    }
    
    public function getEntradaNoticias($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/noticias.twig');
    }
    
    public function getEntradaNuevas($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/nuevas.twig');
    }
    
    public function getEntradaDocumentos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/documentos.twig');
    }
    
    public function getEntradaDatos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/datos.twig');
    }

    public function validar($login, $clave)
    {
        $admin = Admin::where('login', $login)->first();
        if (!$admin) {
            return false;
        }
        if (password_verify($clave, $admin->clave)) {
            $_SESSION['codigo'] = $admin->codigo;
            $_SESSION['dni'] = $admin->dni;
            return true;
        }
        return false;
    }
    
    public function getVideos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/video.twig');
    }
    
    public function logout()
    {
        unset($_SESSION['dni']);
    }

    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'admin/auth/signin.twig');
    }

    public function getSignUp($request, $response)
    {

        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignIn($request, $response)
    {
        $auth = $this->AdminController->validar(
            $request->getParam('login'),
            $request->getParam('clave')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'El usuario o contraseña es incorrecto');
            return $response->withRedirect($this->router->pathFor('admin.signin'));
        }
        $this->flash->addMessage('info', 'Haz iniciado sesion correctamente');
        return $response->withRedirect($this->router->pathFor('admin.dash'));

    }


}
