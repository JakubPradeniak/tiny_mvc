<?php

declare(strict_types=1);

namespace Core\View;

use Core\Exceptions\ViewNotFoundException;

readonly class View
{
    public function __construct(
        private string $view,
        private array $data = []
    ) {
    }

    /**
     * @throws ViewNotFoundException
     */
    public function render(): string
    {
        $templateFile = __APP_ROOT__ . '../src/Views/' . $this->view . '.php';

        if (!file_exists($templateFile)) {
            throw new ViewNotFoundException();
        }

        ob_start();
        include $templateFile;
        return (string)ob_get_clean();
    }
}