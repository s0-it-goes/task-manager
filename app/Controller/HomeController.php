<?php

namespace App\Controller;
use App\View;

class HomeController {
    public function __construct(
        private View $view
    ) 
    {
    }

    public function index()
    {
        return $this->view->render('home/index');
    }
}