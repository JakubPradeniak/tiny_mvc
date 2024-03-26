<?php

declare(strict_types=1);

namespace Core\Security;

class ContentPolicy
{
    public static function use(): void
    {
        // TODO: add option to specify custom security headers
        header("Content-Security-Policy: default-src 'self'; font-src 'self' https://fonts.googleapis.com;");
    }
}