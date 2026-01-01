<?php declare(strict_types=1);

namespace Core\Routing;

class Router
{
    private static array $routes = [];
    private static bool $routesLoaded = false;

    public static function add(string $method, string $path, $handler): void
    {
        $paramNames = [];
        $pattern = preg_replace_callback('/\{(\w+)\}/', function ($m) use (&$paramNames) {
            $paramNames[] = $m[1];
            return '([^\/]+)';
        }, $path);

        $regex = '#^' . rtrim($pattern, '/') . '/?$#';

        self::$routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'regex' => $regex,
            'params' => $paramNames,
            'handler' => $handler,
        ];
    }

    public static function dispatch(string $method, string $path)
    {
        self::loadRoutes();
        $path = self::normalizePath($path);
        self::handleRoute($method, $path);
    }

    private static function normalizePath(string $path): string
    {
        $p = parse_url($path, PHP_URL_PATH) ?: '/';
        return rtrim($p, '/') ?: '/';
    }

    private static function loadRoutes(): void
    {
        if (self::$routesLoaded) {
            return;
        }
        self::$routesLoaded = true;
        require __DIR__ . '/Routes.php';
    }

    private static function handleRoute(string $method, string $path)
    {
        foreach (self::$routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            if (isset($route['regex']) && preg_match($route['regex'], $path, $matches)) {
                array_shift($matches);
                $params = [];
                foreach ($route['params'] as $i => $name) {
                    $params[$name] = $matches[$i] ?? null;
                }

                $callable = $route['handler'];

                $callableNormalized = $callable;
                if (is_array($callable) && is_string($callable[0]) && class_exists($callable[0])) {
                    $class = $callable[0];
                    $method = $callable[1];
                    $instance = new $class();
                    $callableNormalized = [$instance, $method];
                }

                try {
                    if (is_array($callableNormalized)) {
                        $ref = new \ReflectionMethod($callableNormalized[0], $callableNormalized[1]);
                    } else {
                        $ref = new \ReflectionFunction($callableNormalized);
                    }
                    if ($ref->getNumberOfParameters() > 0) {
                        return call_user_func_array($callableNormalized, [$params]);
                    }
                } catch (\ReflectionException $e) {
                    // ignore reflection issues and call normally
                }

                return call_user_func($callableNormalized);
            }

            if (($route['path'] === $path) && ($route['method'] === strtoupper($method))) {
                return call_user_func($route['handler']);
            }
        }

        self::notFound();
    }

    private static function notFound(): void
    {
        if (!headers_sent()) {
            http_response_code(404);
        }
        echo '404 Not Found';
        exit;
    }
}