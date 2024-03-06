<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

class ProcessRequestData
{
    public static function get(): array
    {
        if (count($_GET) === 0) {
            return [];
        }
        return Sanitize::sanitize($_GET);
    }

    public static function post(): array
    {
        if (count($_POST) === 0) {
            return [];
        }
        return Sanitize::sanitize($_POST);
    }
}