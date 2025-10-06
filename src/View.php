<?php

declare(strict_types=1);
namespace App;

class View
{
    public static function render(string $template, array $data = []): void
    {
        $template = __DIR__ . '/../templates/' . $template . '.php';
        if (file_exists($template)) {
            throw new \RuntimeException("Template not found: $template");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $template;
        $content = ob_get_clean();
        $layout = __DIR__ . '/../templates/layout.php';
        if (!file_exists($layout)) {
            echo $content;
            return;
        }
        include $layout;
    }
}