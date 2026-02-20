<?php

declare(strict_types=1);

namespace App;

use App\Config\DBConfig;
use App\Exceptions\Router\RouterException;
use App\HTTP\Request;

class App
{
    public function __construct(
        private Container $container,
        private Router $router,
        private Routes $routes,
        private Request $request,
        private DBConfig $config
    )
    {
        $this->routes->registerRoutes();
    }

    public function run()
    {
        try {
            
            echo $this->router->resolve(
                strtolower($this->request->getServer('REQUEST_METHOD')), 
                $this->request->getServer('REQUEST_URI')
            );

        } catch(RouterException $e) 
        {   
            http_response_code(404);

            echo $e->getMessage() . '</br>'; // this is just for tests, does not really need in the code, better to log the errors somewhere

            echo View::make('error/404');
        }
    }
}