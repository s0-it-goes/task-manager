<?php

declare(strict_types=1);

use App\App;
use App\Container;
use App\Routes;

require __DIR__ . '/../vendor/autoload.php';

define("VIEWS_PATH", __DIR__ . "/../views");

$container = new Container();

$routes = $container->get(Routes::class);
$router = $routes->getRouter();

(new App(
    $container, 
    $router, 
    $routes
))->run();