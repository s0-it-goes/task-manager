<?php

declare(strict_types=1);

namespace App\HTTP;

class Request

{
    public function __construct(
        private array $get,
        private array $post,
        private array $cookie,
        private array $session,
        private array $server,
        private array $files
    )
    {
    }

    private function getValue(array $source, ?string $key = null): mixed
    {

        if(is_null($key)) {
            return $source;
        }

        if(array_key_exists($key, $source)) {
            return $source[$key];
        }

        return null;
    }

    public function getGet(?string $key = null): mixed 
    {
        return $this->getValue($this->get, $key);
    }

    public function getPost(?string $key = null): mixed 
    {
        return $this->getValue($this->post, $key);
    }

    public function getSession(?string $key = null): mixed 
    {
        return $this->getValue($this->session, $key);
    }

    public function getCookie(?string $key = null): mixed
    {
        return $this->getValue($this->cookie, $key);
    }

    public function getServer(?string $key = null): mixed 
    {
        return $this->getValue($this->server, $key);
    }

    public function getFiles(?string $key = null): mixed
    {
        return $this->getValue($this->files, $key);
    }
}