<?php declare(strict_types=1);

namespace Core\Views;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        
        ob_start();
        require __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layout.php";
    }
}