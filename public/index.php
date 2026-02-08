<?php

declare(strict_types=1);

use App\Container;
use App\Controller\HomeController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';



$container = new Container();

$container->set(Router::class, fn(Container $c) => new Router($c));

$router = $container->get(Router::class);

$router->register(
    '/',
    [HomeController::class, 'home']
);

$router->register('/job', function() {
    echo 'job';
});

$router->resolve($_SERVER['REQUEST_URI']);