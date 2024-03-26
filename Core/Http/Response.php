<?php

declare(strict_types=1);

namespace Core\Http;

readonly class Response
{
    public function __construct(
        private string $content = '',
        private int $status = 200,
        private array $headers = [],
    ) {
    }

    public function send(): void
    {
        http_response_code($this->status);
        // TODO: add option to specify custom security headers
        header("Content-Security-Policy: default-src 'self'; font-src 'self' https://fonts.googleapis.com;");
        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }

        echo $this->content;
    }
}