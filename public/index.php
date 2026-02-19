<?php

session_start();

use App\App;
use App\Container;
use App\HTTP\Request;
use App\Routes;

require __DIR__ . '/../vendor/autoload.php';

define("VIEWS_PATH", __DIR__ . "/../views");

$container = new Container();

$routes = $container->get(Routes::class);
$router = $routes->getRouter();

$container->set(Request::class, function() {
    return new Request($_GET, $_POST, $_COOKIE, $_SESSION ? [] : $_SESSION, $_SERVER, $_FILES);
});

$request = $container->get(Request::class);

echo '<pre>';
var_dump($request->getFiles());

(new App(
    $container, 
    $router, 
    $routes
))->run();