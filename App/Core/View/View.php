<?php

declare(strict_types=1);

namespace App\Core\View;

class View
{
    /**
     * $data -> asociativní pole s daty pro šablonu
     */
    public function __construct(
        // Přidání readonly modifikátoru -> členskou proměnnou v tomto případě nebudeme měnit
        private readonly string $template,
        private array $data = []
    ) {
    }

    public function render(): void
    {
        $templateFile = __APP_ROOT__ . 'App/Views/Templates/' . $this->template . '.php';

        if (file_exists($templateFile)) {
            include $templateFile;
        }
    }

    public static function make(
        string $template,
        array $data = []
    ): View {
        $view = new View($template, $data);
        $view->render();
        return $view;
    }
}