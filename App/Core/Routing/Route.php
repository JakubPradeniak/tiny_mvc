<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Http\HttpMethod;
use Closure;

class Route
{
    public function __construct(
        public string $route,
        public HttpMethod $method,
        public array|Closure $handler,
        public bool $protected,
        public int $weight = 0,
    ) {
    }
}