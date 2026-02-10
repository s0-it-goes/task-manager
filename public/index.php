<?php

declare(strict_types=1);

use App\Container;
use App\Controller\HomeController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

define("VIEWS_PATH", __DIR__ . "/../views/");

$container = new Container();

$container->set(Router::class, fn(Container $c) => new Router($c));

$router = $container->get(Router::class);

$router
->get(
    '/',
    [HomeController::class, 'index']
)->get(
    '/job', function() {
    echo 'job';
});
echo readfile(VIEWS_PATH . "/home/index.php");
$router->resolve(strtolower($_SERVER['REQUEST_METHOD']), $_SERVER['REQUEST_URI']);