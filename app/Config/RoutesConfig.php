<?php

namespace App\Config;

class RoutesConfig
{
    private array $config = [
        [
            'method' => 'get', 'uri' => '/', 'action' => [\App\Controller\HomeController::class, 'index']
        ]
    ];

    public function getRoutes()
    {
        return $this->config;
    }
}