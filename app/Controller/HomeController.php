<?php

namespace App\Controller;
use App\View;

class HomeController {
    public function __construct(
    ) 
    {
    }

    public function index(): string
    {
        
        return View::make('home/index');
    }
}