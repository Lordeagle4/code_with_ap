<?php declare(strict_types=1);

namespace Core\Routing;

class Router
{
    private array $routes = [];

    public static function add(string $method, string $path, callable $handler): void
    {
        $instance = new self();
        $instance->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {
                return call_user_func($route['handler']);
            }
        }

        http_response_code(404);
        echo '404 Not Found';
        exit;
    }
}