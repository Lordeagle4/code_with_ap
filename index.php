<?php declare(strict_types=1);

use Core\Routing\Router;

require __DIR__ . '/core/Autoloader.php';

Router::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

