<?php declare(strict_types=1);

namespace Core;

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function ($class) {
            $prefix = __NAMESPACE__ . '\\';
            if (strpos($class, $prefix) === 0) {
                $relative = substr($class, strlen($prefix));
                $file = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
                if (file_exists($file)) {
                    require $file;
                }
            }
        });
    }
}

Autoloader::register();