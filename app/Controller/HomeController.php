<?php

declare(strict_types=1);

namespace App\Controller;

use App\DB;
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