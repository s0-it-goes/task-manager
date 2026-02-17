<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Router\RouterException;

class App
{
    public function __construct(
        private Container $container,
        private Router $router,
        private Routes $routes,
    )
    {
        $this->routes->registerRoutes();
    }

    public function run()
    {
        try {
            
            echo $this->router->resolve(strtolower($_SERVER['REQUEST_METHOD']), $_SERVER['REQUEST_URI']);
        } catch(RouterException $e) 
        {   
            http_response_code(404);

            echo $e->getMessage() . '</br>'; // this is just for tests, does not really need in the code, better to log the errors somewhere

            echo View::make('error/404');
        }
    }
}