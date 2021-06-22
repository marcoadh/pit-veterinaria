<?php

namespace App\Middleware;

class GuestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {

        if ($this->container->AuthController->check()) {
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        $response = $next($request, $response);
        return $response;

    }
}
