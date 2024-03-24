<?php

declare(strict_types=1);

namespace App\Core\Http;

use App\Core\Utils\Sanitize;

class Request
{

    private readonly array $get;
        private readonly array $post;
        private readonly array $files;
        private readonly array $server;

    public function __construct()
    {
        $this->get = Sanitize::sanitize($_GET);
        $this->post = Sanitize::sanitize($_POST);
        $this->files = $_FILES;
        $this->server = $_SERVER;
    }

    public function getGetParams(): array
    {
        return $this->get;
    }

    public function getPostParams(): array
    {
        return $this->post;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}