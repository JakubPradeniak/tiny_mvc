<?php

declare(strict_types=1);

namespace Core\Exceptions;

use Exception;

class ViewNotFoundException extends Exception
{
    protected $message = 'View was not found! Check the file existence.';
}