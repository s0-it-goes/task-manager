<?php

namespace App\HTTP;

class Session
{
    public function __construct(
        private Request $request
    )
    {
    }

    public function get(string $key, ?string $default = null): string|null {
        return $this->request->getSession($key);
    }

    public function set(string $key, string $value): void {
        if(session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION[$key] = $value;
        }
    }

    public function getSessionArray(): array {
        return $this->request->getSession();
    }
}