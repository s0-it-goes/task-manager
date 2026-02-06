<?php

use App\Controller\HomeController;

require __DIR__ . '/../vendor/autoload.php';



$a = new HomeController(1);
var_dump($a);