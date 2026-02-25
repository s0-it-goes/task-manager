<?php

declare(strict_types=1);

namespace App\Controller;

use App\Config\DBConfig;
use App\Container;
use App\DB;
use App\HTTP\Request;
use App\View;

class HomeController {
    public function __construct(
        private DB $database
    ) 
    {   
    }

    public function index(): View
    {
        return View::make('home/index');
    }
}