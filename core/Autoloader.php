<?php declare(strict_types=1);

namespace Core;

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function ($class) {
            $prefixes = [
                __NAMESPACE__ . '\\' => __DIR__ . '/', // Core\ -> core/
            ];

            // PSR-4 style prefix mapping
            foreach ($prefixes as $prefix => $baseDir) {
                if (strpos($class, $prefix) === 0) {
                    $relative = substr($class, strlen($prefix));
                    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
                    if (file_exists($file)) {
                        require $file;
                        return;
                    }
                }
            }

            // Fallback: attempt to locate class from project root
            $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}

Autoloader::register();