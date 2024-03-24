<?php

declare(strict_types=1);

namespace Core\Routing;

use Closure;
use Core\Http\HttpMethod;

readonly class Route
{
    public function __construct(
        public string $route,
        public HttpMethod $method,
        public array|Closure $handler,
        public bool $protected,
        public int $weight = 0,
    ) {
    }

    public static function make(
        string $route,
        HttpMethod $method,
        array|Closure $handler,
        bool $protected = false,
        int $weight = 0,
    ): self {
        return new self($route, $method, $handler, $protected, $weight);
    }

}