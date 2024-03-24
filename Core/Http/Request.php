<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Utils\Sanitize;

readonly class Request
{

    private array $get;
    private array $post;
    private array $files;
    private array $server;

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

    public function getRequestMethod(): HttpMethod
    {
        $httpMethod = HttpMethod::class;
        if (isset($this->post['_method'])) {
            return $httpMethod::from($this->post['_method']);
        }

        return $httpMethod::from($this->server['REQUEST_METHOD']);
    }

    public function getRequestUri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }
}