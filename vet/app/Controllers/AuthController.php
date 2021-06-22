<?php

namespace App\Controllers;

use App\Models\Modelos\Usuarios;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

Class AuthController extends Controller
{



    public function getAll($limit = -1, $page = -1)
    {
        if ($limit < 0 && $page < 0) {
            $data = $this->db->from($this->table)
                ->orderBy('codigo DESC')
                ->fetchAll();
        } else {
            $data = $this->db->from($this->table)
                ->limit($limit)
                ->offset($page)
                ->orderBy('codigo DESC')
                ->fetchAll();
        }

        $total = $this->db->from($this->table)
            ->select('COUNT(*) Total')
            ->fetch()
            ->Total;

        return [
            'total' => $total,
            'data'  => $data

        ];
    }



    public function usuario()
    {
        $ses_codigo = isset($_SESSION['codigo']) ? $_SESSION['codigo'] : '';
        $usuario = Usuarios::where('codigo', $ses_codigo)->first();
        return $usuario;
    }

    public function check()
    {
        return isset($_SESSION['dni']);
    }

    public function attempt($dni, $clave)
    {
        $usuario = Usuarios::where('dni', $dni)->first();
        if (!$usuario) {
            return false;
        }
        if (password_verify($clave, $usuario->clave)) {
            $_SESSION['codigo'] = $usuario->codigo;
            $_SESSION['dni'] = $usuario->dni;
			$_SESSION['tipo_user'] = $usuario->tipo_user;
            $_SESSION['distrito'] = $usuario->distrito;
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
        return $response->withRedirect($this->router->pathFor('admin.signin'));
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
        $auth = $this->AuthController->attempt(
            $request->getParam('dni'),
            $request->getParam('clave')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'El usuario o contraseña es incorrecta');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        $this->flash->addMessage('info', 'Haz iniciado sesion correctamente');
        return $response->withRedirect($this->router->pathFor('auth.documento'));

    }


    public function postSignUp($request, $response)
    {
        $validation = $this->validator->validate($request, [
            'dni' => v::noWhitespace()->notEmpty()->dniDisponible(),
            'nombres' => v::notEmpty(),
            'apellidopaterno' => v::notEmpty(),
            'apellidomaterno' => v::notEmpty(),
            'email' => v::noWhitespace()->notEmpty()->email(),
            'tel' => v::notEmpty(),
            'casa' => v::notEmpty(),
            'distrito' => v::notEmpty(),
            'direccion' => v::notEmpty(),
            'naci' => v::noWhitespace()->notEmpty(),
            'clave' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $usuario = Usuarios::create([
            'usuario' => $request->getParam('dni'),
            'tipo_user' => 1,
            'nombres' => $request->getParam('nombres'),
            'apellidopaterno' => $request->getParam('apellidopaterno'),
            'apellidomaterno' => $request->getParam('apellidomaterno'),
            'correo' => $request->getParam('email'),
            'telefono' => $request->getParam('tel'),
            'casa' => $request->getParam('casa'),
            'dni' => $request->getParam('dni'),
            'distrito' => $request->getParam('distrito'),
            'direccion' => $request->getParam('direccion'),
            'fecha_nacimiento' => $request->getParam('naci'),
            'clave' => password_hash($request->getParam('clave'), PASSWORD_DEFAULT),
        ]);

        $this->flash->addMessage('info', 'Tu te haz registrado exitosamente');
        $this->AuthController->attempt($usuario->dni, $request->getParam('clave'));
        return $response->withRedirect($this->router->pathFor('auth.solicitud'));

    }
}
