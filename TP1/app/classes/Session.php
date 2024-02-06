<?php

class Session
{
    function __construct()
    {
        session_start();
    }

    public function add(string $key, $data)
    {
        $_SESSION[$key] = $data; 
    }

    public function get(string $key)
    {
        return $_SESSION[$key];
    }

    public function destroy(string $key)
    {
        unset($_SESSION);
        session_destroy();
    }

    public function isConnected()
    {
        return isset($_SESSION['user']);
    }
}