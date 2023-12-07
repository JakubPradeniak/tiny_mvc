<?php

declare(strict_types=1);

namespace App\AppCore\Routing;

use App\AppCore\Enums\HttpMethod;
use App\AppCore\Exceptions\RouteNotFoundException;
use App\AppCore\Utils\Debug;
use App\AppCore\Utils\Redirect;
use App\Routes\Routes;
use Closure;

class Router
{
    /** @var Route[] $routes */
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    private function processRoute(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function routeExists(HttpMethod $method, string $route): bool
    {
        foreach ($this->routes as $currentRoute) {
            if ($route === $currentRoute->route && $method === $currentRoute->method) {
                return true;
            }
        }

        return false;
    }

    private function addRoute(HttpMethod $method, string $route, array|Closure $handler, bool $protected): void
    {
        if (!$this->routeExists($method, $route)) {
            $this->routes[] = new Route($route, $method, $handler, $protected);
        }
    }

    // Cesty pro zobrazení obsahu
    public function get(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Get, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro vytváření obsahu
    public function post(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Post, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro úpravy obsahu
    public function patch(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Patch, $route, $handler, $protected);
        return $this;
    }

    // Cesty pro odstranění obsahu
    public function delete(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Delete, $route, $handler, $protected);
        return $this;
    }

    public function resolveRequest(): void
    {
        $requestRoute = $this->processRoute();
        $requestMethod = htmlspecialchars($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            $routeRegex = preg_replace('/{.*}/', '.*', $route->route);
            $match = preg_match('|^' . $routeRegex . '$|', $requestRoute);


            if ($match === 1 && $route['method'] === $requestMethod) {
                // Ošetření přístupu k chráněným cestám -> pokud nebude uživate přihlášený -> redirect na Homepage
                // Zpracování implementujeme v Router, abychom následně mohli na chránených stránkách bezpečně
                // předpokládat, že uživatel je přihlášen a budeme pracovat s daty v $_SESSION['loggedUser']
                if ($route->protected && !isset($_SESSION['loggedUser'])) {
                    Redirect::redirect(Routes::Homepage, []);
                }

                $params = [];

                if ($requestRoute !== '/') {
                    $routeParts = explode('/', $route->route);              // ['', 'someUrl', '{id}', 'edit']
                    $requestRouteParts = explode('/', $requestRoute);       // ['', 'someUrl', '1265', 'edit']

                    foreach ($routeParts as $index => $value) {
                        $fragment = [];
                        preg_match("/(?<={).+?(?=})/", $value, $fragment);
                        if ($fragment) {
                            $params[$fragment[0]] = $requestRouteParts[$index];
                        }
                    }
                }

                if (is_callable($route->handler)) {
                    call_user_func($route->handler);
                    return;
                }

                if (class_exists($route->handler[0])) {
                    $controller = new $route->handler[0]();
                    if (method_exists($controller, $route->handler[1])) {
                        // Tato implementace háže v PHP 8+ chybu -> jedná se o bug v implmentaci PHP,
                        // proto musíme použít jiný způsob volání
                        // call_user_func_array([$controller, $route['handler'][1]], $params);

                        // Metodu si uložíme do pomocné proměnné -> nechci používat zápis $controller->$route['handler'][1]($params);
                        $method = $route->method[1];

                        // Klasické volání metody kontroleru => funguje protože PHP tento kód vyhodnotí např.
                        // pro cestu /someUrl/ID/upravit na:
                        // Controller->edit($params);
                        $controller->$method($params);
                        return;
                    }
                }
            }
        }

        throw new RouteNotFoundException("Route: $requestRoute not found!");
    }

    // Pomocná funkce pro debugování routeru
    public function dumpRoutes(): void
    {
        Debug::dd($this->routes);
    }
}