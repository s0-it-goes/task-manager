CREATE DATABASE IF NOT EXISTS taskmanager_db;

use taskmanager_db;

CREATE TABLE IF NOT EXISTS users(
    id int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username varchar(255) NOT NULL UNIQUE,
    passwd varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);