<?php

declare(strict_types=1);

namespace Core\Routing;

use App\Routes\Routes;

class Redirect
{
    public static function redirect(Routes $route, array $params): never
    {
        $newLocation = Url::create($route, $params);
        header("Location: $newLocation");
        exit();
    }
}