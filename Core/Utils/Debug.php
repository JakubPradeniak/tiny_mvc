<?php

declare(strict_types=1);

namespace Core\Utils;

class Debug
{
    public static function d($var): void
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public static function dd($var): never
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';

        die();
    }
}