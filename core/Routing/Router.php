<?php declare(strict_types=1);

namespace Core\Routing;

class Router
{
    private static array $routes = [];

    public static function add(string $method, string $path, callable $handler): void
    {
        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public static function dispatch(string $method, string $path)
    {
        $path = parse_url($path, PHP_URL_PATH) ?: '/';
        foreach (self::$routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                return call_user_func($route['handler']);
            }
        }

        http_response_code(404);
        echo '404 Not Found';
        exit;
    }
}