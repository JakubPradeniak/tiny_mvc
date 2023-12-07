<?php

declare(strict_types=1);

namespace App;

class App
{
    public function __construct()
    {
        session_start();
        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('__APP_DOMAIN__', 'http://localhost/');
    }

    public function run(): void
    {
        echo "Running...";
    }
}