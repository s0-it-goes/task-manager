<?php

namespace App;

use App\Config\RoutesConfig;

class Routes
{
    public function __construct(
        private Router $router,
        private RoutesConfig $routesConfig
    )
    {
    }

    public function registerRoutes()
    {
        $config = $this->routesConfig->getRoutes();

        foreach($config as $route) {
            $method = $route['method'];
            $uri    = $route['uri'];
            $action = $route['action'];
            
            $this->router->$method($uri, $action);
        }
    }

    public function getRouter()
    {
        return $this->router;
    }
}