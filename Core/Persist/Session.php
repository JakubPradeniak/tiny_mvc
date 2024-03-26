<?php

declare(strict_types=1);

namespace Core\Persist;

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

    public static function delete(string|array|null $keys): void
    {
        if (!$keys) {
            session_unset();
        }

        if (is_array($keys)) {
            foreach ($keys as $key) {
                unset($_SESSION[$key]);
            }
        } else {
            unset($_SESSION[$keys]);
        }
    }
}
