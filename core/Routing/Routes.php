<?php declare(strict_types=1);

use Core\Routing\Router;
use Core\Controllers\Home;
use Core\Controllers\About;

Router::add('GET', '/', [Home::class, 'index']);

Router::add('GET', '/about', [About::class, 'index']);

Router::add('GET', '/users/{id}', function ($params) {
    echo "User ID: " . ($params['id'] ?? 'unknown');
});