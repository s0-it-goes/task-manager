<?php

declare(strict_types=1);

namespace App\Controller;

use App\DB;
use App\HTTP\Request;
use App\HTTP\Session;
use App\View;

class HomeController {
    public function __construct(
        private DB $database,
        private Request $request,
        private Session $session
    ) 
    {   
    }

    public function index(): View
    {
        return View::make('home/index');
    }
}