<?php

declare(strict_types=1);

namespace App\Routes;

use Core\Http\HttpMethod;
use Core\Routing\Route;

class WebRoutes
{
    public static function get(): array
    {
        return [
            Route::make(Routes::Homepage->value, HttpMethod::Get, function () {
                echo "Homepage";
            }),
            Route::make(Routes::AppError->value, HttpMethod::Get, function () {
                echo "Chyba aplikace";
            })
        ];
    }
}
