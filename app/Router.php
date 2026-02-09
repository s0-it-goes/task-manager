<?php

namespace App;

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
            throw new \Exception('not valid route');
        }

        if(is_callable($action)) {
            return call_user_func($action);
        }

        if(!is_array($action)) {
            throw new \Exception('invalid action argument in resolve method');
        }

        if(count($action) !== 2) {
            throw new \Exception('invalid action argument array size in resolve method');
        }

        [$class, $method] = $action;

        if(!class_exists($class)) {
            throw new \Exception('controller "' . $class . '" does not exist'); 
        }

        if(!method_exists($class, $method)) {
            throw new \Exception('method "' . $method . '" does not exist in controller "' . $class . '"');
        }
        
        $class = $this->container->get($class);

        return call_user_func([$class, $method]);
        
    }
}