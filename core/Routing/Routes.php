<?php declare(strict_types=1);

use Core\Routing\Router;

Router::add('GET', '/', function () {
    echo 'Welcome to the home page!';
});