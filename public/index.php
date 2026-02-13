<?php

declare(strict_types=1);

use App\Container;
use App\Controller\HomeController;
use App\Exceptions\Router\RouteNotFoundException;
use App\Exceptions\Router\RouterException;
use App\Router;
use App\View;

require __DIR__ . '/../vendor/autoload.php';

define("VIEWS_PATH", __DIR__ . "/../views");

$container = new Container();

$container->set(Router::class, fn(Container $c) => new Router($c));

$router = $container->get(Router::class);

try {
    $router
    ->get(
        '/',
        [HomeController::class, 'index']
    )->get(
        '/job', function() {
        echo 'job';
    });

    echo $router->resolve(strtolower($_SERVER['REQUEST_METHOD']), $_SERVER['REQUEST_URI']);
} catch(RouterException $e) 
{   
    http_response_code(404);

    echo $e->getMessage() . '</br>'; // this is just for tests, does not really need in the code, better to log the errors somewhere

    echo View::make('error/404');
}