<?php

namespace App;

use App\Exceptions\Router\RouteNotFoundException;
use App\Exceptions\Router\RouterClassException;
use App\Exceptions\Router\RouterException;
use App\Exceptions\Router\RouterMethodException;

class Router
{
    private array $routes = [];

    public function __construct(
        private Container $container,
    )
    {
    }

    private function register(string $requestMethod, string $uri, callable|array $action): static
    {
        $this->routes[$requestMethod][$uri] = $action;

        return $this;
    }

    public function get(string $uri, callable|array $action): Router
    {
        return $this->register('get', $uri, $action);
    }

    public function post(string $uri, callable|array $action): Router
    {
        return $this->register('post', $uri, $action);
    }

    public function resolve(string $method, string $requestUri)
    {
        $uri = explode('?', $requestUri)[0];

        $action = $this->routes[$method][$uri] ?? null;

        if(!$action) {
            throw new RouteNotFoundException('route not found');
        }

        if(is_callable($action)) {
            return call_user_func($action);
        }

        if(!is_array($action)) {
            throw new RouterException('invalid action argument in resolve method');
        }

        if(count($action) !== 2) {
            throw new RouterException('invalid action argument array size in resolve method');
        }

        [$class, $method] = $action;

        if(!class_exists($class)) {
            throw new RouterClassException('route "' . $class . '" does not exist'); 
        }

        if(!method_exists($class, $method)) {
            throw new RouterMethodException('method "' . $method . '" does not exist in route "' . $class . '"');
        }
        
        $class = $this->container->get($class);

        return call_user_func([$class, $method]);
        
    }
}