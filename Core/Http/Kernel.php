<?php

declare(strict_types=1);

namespace Core\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        return new Response('Hello World!');
    }
}