<?php

declare(strict_types=1);

namespace Core\Routing;

use Closure;
use Core\Exceptions\RouteNotFoundException;
use Core\Http\HttpMethod;
use Core\Utils\Debug;
use Core\Utils\Redirect;
use src\Routes\Routes;

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
        return str_replace(
            getenv('APP_SUB_FOLDERS'),
            '',
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
    }

    private function sortRoutes(): void
    {
        usort($this->routes, function (Route $a, Route $b) {
            if ($a->weight === $b->weight) {
                return 0;
            }
            return $a->weight > $b->weight ? 1 : -1;
        });
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

    public function get(string $route, array|Closure $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Get, $route, $handler, $protected);
        return $this;
    }

    public function post(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Post, $route, $handler, $protected);
        return $this;
    }

    public function patch(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Patch, $route, $handler, $protected);
        return $this;
    }

    public function delete(string $route, array $handler, bool $protected = false): Router
    {
        $this->addRoute(HttpMethod::Delete, $route, $handler, $protected);
        return $this;
    }

    public function resolveRequest(): void
    {
        $this->sortRoutes();
        $requestRoute = $this->processRoute();
        $requestMethod = htmlspecialchars($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            $routeRegex = preg_replace('/{.*}/', '.*', $route->route);
            $match = preg_match('|^' . $routeRegex . '$|', $requestRoute);


            if ($match === 1 && $route['method'] === $requestMethod) {
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
                        $method = $route->method[1];
                        $controller->$method($params);
                        return;
                    }
                }
            }
        }

        throw new RouteNotFoundException("Route: $requestRoute not found!");
    }

    public function dumpRoutes(): void
    {
        Debug::dd($this->routes);
    }
}