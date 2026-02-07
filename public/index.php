<?php

use App\Container;
use App\Controller\HomeController;

require __DIR__ . '/../vendor/autoload.php';



$container = new Container();
$home = $container->get(HomeController::class);
echo $home->get(5);