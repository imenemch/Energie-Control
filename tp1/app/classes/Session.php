<?php

namespace App;

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
 return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
 }

 public function destroy()
{
unset($_SESSION);
session_destroy();
}

 public function isConnected()
 {
// return isset($this->get('user))
return isset($_SESSION['email']);
}

public function hasRole(string $role)
{
return $_SESSION['email']['role'] == $role; //? true : false; // test ternaire 3 partie si c'est vrai si c'est faux. if en 1 ligne
    }
}