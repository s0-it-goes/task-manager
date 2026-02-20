<?php

namespace App\Config;

class DBConfig
{
    private array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'host' => $env['DB_HOST'],
            'user' => $env['DB_USER'],
            'pass' => $env['DB_PASS'],
            'dbname' => $env['DB_NAME'],
            'driver' => $env['DB_DRIVER']
        ];
    }

    public function __get($name): string|null
    {
        return $this->config[$name] ?? null;   
    }
}