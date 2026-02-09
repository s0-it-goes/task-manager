<?php

declare(strict_types=1);

use App\Container;
use App\Controller\HomeController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';



$container = new Container();

$container->set(Router::class, fn(Container $c) => new Router($c));

$router = $container->get(Router::class);

$router
->get(
    '/',
    [HomeController::class, 'home']
)->get(
    '/job', function() {
    echo 'job';
});

$router->resolve(strtolower($_SERVER['REQUEST_METHOD']), $_SERVER['REQUEST_URI']);