<?php

declare(strict_types=1);

namespace Core;

use Closure;
use Core\Exceptions\EnvFileNotFoundException;
use Core\Exceptions\RouteNotFoundException;
use Core\Routing\Router;
use Core\Utils\EnvParser;
use Core\View\View;

class App
{
    public function __construct()
    {
        session_start();
        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');
        EnvParser::parse(__APP_ROOT__ . '../.env');
    }

    public function run(): void
    {
        echo "Hello World";
    }
}