<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Utils\Sanitize;

readonly class Request
{

    private array $get;
    private array $post;
    private array $files;
    private array $cookies;
    private array $server;

    public function __construct()
    {
        $this->get = Sanitize::sanitize($_GET);
        $this->post = Sanitize::sanitize($_POST);
        $this->files = $_FILES;
        $this->cookies = Sanitize::sanitize($_COOKIE);;
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

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getRequestMethod(): HttpMethod
    {
        $httpMethod = HttpMethod::class;

        if (isset($this->post['_method'])) {
            return $httpMethod::from(htmlspecialchars($this->post['_method']));
        }

        return $httpMethod::from($this->server['REQUEST_METHOD']);
    }

    public function getRequestUri(): string
    {
        $appSubFolders = getenv('APP_SUB_FOLDERS');

        if ($appSubFolders) {
            return str_replace(
                getenv('APP_SUB_FOLDERS'),
                '',
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );
        }

        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}