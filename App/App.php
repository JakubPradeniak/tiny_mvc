<?php

declare(strict_types=1);

namespace App;

use App\AppCore\Exceptions\EnvFileNotFoundException;
use App\AppCore\Exceptions\RouteNotFoundException;
use App\AppCore\Routing\Router;
use App\AppCore\Utils\EnvParser;
use App\AppCore\View\View;
use App\Routes\Routes;
use Closure;

class App
{
    private Router $router;

    public function __construct()
    {
        session_start();
        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('__APP_DOMAIN__', 'http://localhost/');

        try {
            EnvParser::parse(__APP_ROOT__ . '.env');
        } catch (EnvFileNotFoundException $e) {
            // TODO: create view
            View::make('AppError', ['title' => 'Chyba aplikace']);
            die();
        }

        $this->router = new Router();
    }

    private function registerRoutes(): void
    {
        // TODO: crete controller
        $this->router->get(Routes::Homepage->value, ['Controller class', 'Method']);

        $this->router->get(
            Routes::AppError->value,
            Closure::fromCallable(fn() => View::make('AppError', ['Chyba aplikace']))
        );
    }

    public function run(): void
    {
        $this->registerRoutes();

        try {
            $this->router->resolveRequest();
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            // TODO: create view
            View::make('NotFound', ['title' => 'Nenalezeno']);
        }
    }
}