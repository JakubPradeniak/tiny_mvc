<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

use Exception;

class EnvFileNotFoundException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}