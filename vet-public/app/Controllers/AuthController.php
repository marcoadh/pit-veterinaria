<?php

namespace App\Controllers;

use App\Models\Usuarios;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class AuthController extends Controller
{
    public function usuario()
    {
        $ses_codigo = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
        $usuario = Usuarios::where('id_usuario', $ses_codigo)->first();
        return $usuario;
    }

    public function check()
    {
        return isset($_SESSION['dni']);
    }

    public function attempt($login, $clave)
    {

        $usuario = Usuarios::select('cliente.id_cliente as id_cliente',
                'usuario.id_usuario as id_usuario',
                'usuario.dni as dni',
                'usuario.password as password')
        ->join('cliente', 'usuario.id_usuario', '=', 'cliente.id_usuario')
        ->where('usuario.login', $login)->first();
           
        if (!$usuario) {
            return false;
        }
        if (password_verify($clave, $usuario->password)) {
            $_SESSION['id_usuario'] = $usuario->id_usuario;
            $_SESSION['id_cliente'] = $usuario->id_cliente;
            $_SESSION['dni'] = $usuario->dni;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['dni']);
    }

    public function getSignOut($request, $response)
    {   
        $this->AuthController->logout();
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'templates/login.twig');
    }

    public function getSignUp($request, $response)
    {

        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignIn($request, $response)
    {
        $auth = $this->AuthController->attempt(
            $request->getParam('dni'),
            $request->getParam('clave')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'El DNI o contraseña son incorrectos');
            return $response->withRedirect($this->router->pathFor('login'));
        }
        
        $this->flash->addMessage('info', 'Haz iniciado sesion correctamente');
        return $response->withRedirect($this->router->pathFor('dashboard'));

    }



}
