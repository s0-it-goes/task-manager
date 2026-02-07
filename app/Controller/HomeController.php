<?php

namespace App\Controller;

class HomeController {
    public function __construct() {
    }

    public function get(int $c)
    {
        return $c;
    }
}