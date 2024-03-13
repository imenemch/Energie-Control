<?php
namespace App;

class Session
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function add(string $key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }

    public function isConnected()
    {
        return isset($_SESSION['email']); 
    }

    public function hasRole(string $role)
    {

        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }
        

}
