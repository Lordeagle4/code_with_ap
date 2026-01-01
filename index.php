<?php declare(strict_types=1);

require __DIR__ . '/core/Autoloader.php';
\Core\Autoloader::register();

$db = require __DIR__ . '/config/db.php';

require __DIR__ . '/core/Routing/Routes.php';

$router = new \Core\Routing\Router();
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

