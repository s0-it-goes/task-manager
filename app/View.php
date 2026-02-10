<?php

namespace App;

class View
{
    public function __construct(
        private string $view,
        private array $args
    )
    {

    }

    public function render(string $path)
    {
        echo readfile(VIEWS_PATH . $path . '.php');
    }
}