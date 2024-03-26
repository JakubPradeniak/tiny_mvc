<?php

declare(strict_types=1);

namespace Core\Persist;

use Core\Security\Sanitize;

class Cookie
{
    public static function set(
        string $name,
        string $value,
        int $expiration,
        bool $httpOnly = true,
        bool $secure = true
    ): bool {
        return setcookie($name, $value, time() + $expiration, '/', null, $secure, $httpOnly);
    }

    public static function get(string $cookieName, bool $jsonDecode = false): mixed
    {
        $data = $_COOKIE[$cookieName];
        if (empty($data)) {
            return null;
        }

        if ($jsonDecode) {
            return json_decode($data);
        }

        return Sanitize::sanitize($data);
    }

    public static function destroy(string $cookieName): bool
    {
        return setcookie($cookieName, '', time() - 60, '/', null);
    }
}