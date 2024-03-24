<?php

declare(strict_types=1);

namespace Core\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}