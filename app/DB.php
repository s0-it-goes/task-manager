<?php

namespace App;

use App\Config\DBConfig;
use PDO;
/*
    @mixin PDO
*/
class DB
{
    private PDO $pdo;

    public function __construct(
        private DBConfig $config
    )
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO(
                $this->config->driver . ':host=' . $this->config->host . ';dbname=' . $this->config->dbname,
                $this->config->user,
                $this->config->pass,
                $defaultOptions
            );
        } catch(\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
}