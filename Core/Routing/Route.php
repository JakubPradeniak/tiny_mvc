<?php

declare(strict_types=1);

namespace Core\Routing;

use Closure;
use Core\Http\HttpMethod;

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