<?php

declare(strict_types=1);

namespace Core\Utils;

use Core\Routing\Url;
use src\Routes\Routes;

class Redirect
{
    public static function redirect(Routes $route, array $params): never
    {
        $newLocation = Url::create($route, $params);
        header("Location: $newLocation");
        exit();
    }
}