<?php

namespace App\Core;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }
    }

    public function set(string $key, $value) : Session
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function remove(string $key) : void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function clear() : void
    {
        session_unset();
    }

    private static function has(string $key) : bool
    {
        return array_key_exists($key, $_SESSION);
    }

}