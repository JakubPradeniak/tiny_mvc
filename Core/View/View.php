<?php

declare(strict_types=1);

namespace Core\View;

readonly class View
{
    public function __construct(
        private string $view,
        private array $data = []
    ) {
    }

    public function render(): string
    {
        $templateFile = __APP_ROOT__ . '../src/Views/' . $this->$view . '.php';

        if (!file_exists($templateFile)) {
            // TODO: throw an exception
        }

        ob_start();

        include $templateFile;

        return ob_get_clean();
    }
}