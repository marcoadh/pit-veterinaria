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

    public function getArticulos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/articulos.twig');
    }

    public function getFormulario($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/formulario.twig');
    }
         
      public function getsuscripciones($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/suscripciones.twig');
    }
    
    public function getActualidad($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/actualidad.twig');
    }
    
     public function getServicios($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/servicios.twig');
    }
    
     public function getEncuesta($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/encuestas.twig');
    }
    
    public function getProductos($request, $response, $args)
    {
        return $this->view->render($response, 'admin/auth/productos.twig');
    }

    public function getViewDashSignIn($request, $response)
    {
        return $this->view->render($response, 'admin/auth/signin.twig');
    }
    
    public function getClientes($request, $response, $args)
   {
       return $this->view->render($response, 'admin/auth/clientes.twig');
   }

    public function validar($login, $clave)
    {
        $admin = Admin::where('login', $login)->first();
        if (!$admin) {
            return false;
        }
        if (password_verify($clave, $admin->password)) {
            $_SESSION['codigo'] = $admin->id_usuario;
            $_SESSION['dni'] = $admin->dni;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['dni']);
    }

    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
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
            $this->flash->addMessage('error', 'El usuario o contraseña es incorrecta');
            return $response->withRedirect($this->router->pathFor('admin.signin'));
        }
        $this->flash->addMessage('info', 'Haz iniciado sesion correctamente');
        return $response->withRedirect($this->router->pathFor('admin.dash'));

    }


}
