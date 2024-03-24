<?php

declare(strict_types=1);

namespace Core;

use Core\Http\Kernel;
use Core\Http\Request;
use Core\Utils\EnvParser;

class App
{
    private Kernel $httpKernel;

    public function __construct()
    {
        session_start();
        define('__APP_ROOT__', $_SERVER['DOCUMENT_ROOT'] . '/');
        EnvParser::parse(__APP_ROOT__ . '../.env');

        $this->httpKernel = new Kernel();
    }

    public function run(): void
    {
        $request = new Request();
        $response = $this->httpKernel->handle($request);
        $response->send();
    }
}