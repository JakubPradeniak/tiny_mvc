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
        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }

        echo $this->content;
    }
}