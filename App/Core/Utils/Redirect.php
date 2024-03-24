<?php

declare(strict_types=1);

namespace App\Core\Utils;

use App\Routes\Routes;
use App\Core\Routing\Url;

class Redirect
{
    public static function redirect(Routes $route, array $params): never
    {
        $newLocation = Url::create($route, $params);
        header("Location: $newLocation");
        exit();
    }
}