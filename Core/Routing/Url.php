<?php

declare(strict_types=1);

namespace Core\Routing;

use App\Routes\Routes;

class Url
{
    public static function create(Routes $route, array $params): string
    {
        $regexArray = [];
        $values = [];

        foreach ($params as $key => $value) {
            $regexArray[] = '/{' . $key . '}/';
            $values[] = $value;
        }

        return preg_replace($regexArray, $values, $route->value);
    }
}