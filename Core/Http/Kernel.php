<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Routing\Router;
use Core\Routing\RouterStatus;

class Kernel
{
    public function handle(Request $request): Response
    {
        $routerResponse = Router::findMatch($request);

        if ($routerResponse->status === RouterStatus::NotFound) {
            return new Response('Not Found!', 404);
        }

        if (is_callable($routerResponse->handler)) {
            return call_user_func_array($routerResponse->handler, $routerResponse->urlParameters);
        }

        if (is_array($routerResponse->handler)) {
            [$controller, $method] = $routerResponse->handler;

            return call_user_func_array([new $controller(), $method], $routerResponse->urlParameters);
        }

        return new Response('Not implemented!', 501);
    }
}