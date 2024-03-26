<?php

declare(strict_types=1);

namespace Core\Security;

use Core\Persist\Session;

class Form
{
    public const TOKEN_ID = 'csrf_token';

    public static function getToken(): string
    {
        $token = hash('sha512', microtime());

        Session::set('csrf_token', $token);

        return '<input type="hidden" name="' . self::TOKEN_ID . '" value="' . $token . '">';
    }

    public static function validateToken(string $token): bool
    {
        $storedToken = Session::get(self::TOKEN_ID);

        return $token === $storedToken;
    }
}