<?php declare(strict_types=1);

use Core\Routing\Router;

Router::add('GET', '/', function () {
    $homeController = new \Core\Controllers\Home();
    $homeController->index();
});

Router::add('GET', '/about', function () {
    $aboutController = new \Core\Controllers\About();
    $aboutController->index();
});