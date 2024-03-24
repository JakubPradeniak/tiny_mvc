<?php

declare(strict_types=1);

namespace Core\Routing;

use Closure;
use RouterStatus;

readonly class RouterResponse
{
    public function __construct(
        public RouterStatus $status,
        public array|Closure $handler,
        public array $urlParameters
    ) {
    }
}