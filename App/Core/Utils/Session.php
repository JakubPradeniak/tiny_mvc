<?php

declare(strict_types=1);

namespace App\Core\Utils;

/*
 * Pomocná třída pro dočasné ukládání dat to $_SESSION
 */

class Session
{
    public static function set(string $key, mixed $data): void
    {
        $_SESSION[$key] = $data;
    }

    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public static function delete(string|array $keys): void
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                unset($_SESSION[$key]);
            }
        } else {
            unset($_SESSION[$keys]);
        }
    }
}