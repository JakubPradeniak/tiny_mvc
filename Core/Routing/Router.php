<?php

declare(strict_types=1);

namespace Core\Routing;

use App\Routes\Routes;
use App\Routes\WebRoutes;
use Core\Http\Request;
use Core\Utils\Session;
use RouterStatus;

class Router
{
    private static function sortRoutes(array $routes): void
    {
        usort($routes, function (Route $a, Route $b) {
            if ($a->weight === $b->weight) {
                return 0;
            }
            return $a->weight > $b->weight ? 1 : -1;
        });
    }

    public static function findMatch(Request $request): RouterResponse
    {
        /** @var Route[] $routes */
        $routes = WebRoutes::get();

        self::sortRoutes($routes);

        $requestRoute = $request->getRequestUri();
        $requestMethod = $request->getRequestMethod();

        foreach ($routes as $route) {
            $routeRegex = preg_replace('/{.*}/', '.*', $route->route);
            $match = preg_match('|^' . $routeRegex . '$|', $requestRoute);


            if ($match === 1 && $route->method === $requestMethod) {
                if ($route->protected && !Session::get('loggedUser')) {
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

                return new RouterResponse(RouterStatus::Found, $route->handler, $params);
            }
        }

        return new RouterResponse(RouterStatus::NotFound, [], []);
    }
}
