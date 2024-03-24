<?php

declare(strict_types=1);

namespace App\Routes;

use Core\Http\HttpMethod;
use Core\Http\Response;
use Core\Routing\Route;

class WebRoutes
{
    public static function get(): array
    {
        return [
            Route::make(Routes::Homepage->value, HttpMethod::Get, function () {
                return new Response('Homepage');
            }),
        ];
    }
}
