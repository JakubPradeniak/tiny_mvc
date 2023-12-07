<?php

declare(strict_types=1);

namespace App\AppCore\Routing;

use App\AppCore\Enums\HttpMethod;
use Closure;

class Route
{
    public function __construct(
        public string $route,
        public HttpMethod $method,
        public array|Closure $handler,
        public bool $protected,
    )
    {
    }
}