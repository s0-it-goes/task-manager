<?php

namespace App;

use App\Controller\HomeController;

class Router
{
    private array $routes = [];

    public function __construct(
        private Container $container,
    )
    {
    }

    public function register(string $route, callable|array $action)
    {
        $this->routes[$route] = $action;    
    }

    public function resolve(string $requestUri)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$route] ?? null;

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