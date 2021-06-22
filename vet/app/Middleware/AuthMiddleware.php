<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        //check si el usuario inicio sesion
        if (!$this->container->AuthController->check()) {
            $this->container->flash->addMessage('error', 'Necesitas iniciar sesión antes de ingresar');
            return $response->withRedirect($this->container->router->pathfor('auth.signin'));
        }


        $response = $next($request, $response);

        return $response;

    }
}
