<?php declare(strict_types=1);

namespace Core\Views;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../Views/{$view}.php";
    }
}