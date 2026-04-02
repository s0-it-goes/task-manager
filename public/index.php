<?php

session_start();

use App\App;
use App\Config\DBConfig;
use App\Container;
use App\HTTP\Request;
use App\Routes;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define("VIEWS_PATH", __DIR__ . "/../views");

$container = new Container();

$container->set(Container::class, fn() => $container);

$container->set(
    DBConfig::class, 
    fn() => new DBConfig($_ENV)
);

$container->set(Request::class, 
    function() {
        return new Request(
            $_GET, 
            $_POST, 
            $_COOKIE, 
            $_SESSION ?? [], 
            $_SERVER,
            $_FILES
        );
});

$routes = $container->get(Routes::class);
$router = $routes->getRouter();
$request = $container->get(Request::class);
$config = $container->get(DBConfig::class);


(new App(
    $container, 
    $router, 
    $routes,
    $request,
    $config
))->run();