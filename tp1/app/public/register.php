<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_POST['send']))
{
    $page->insertUsers('users', [ // Utilisez insertUsers au lieu de insert
        'email' => $_POST['email'],
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'adresse' => $_POST['adresse'],
        'tel' => $_POST['tel'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);
    header('Location: index.php');
    exit(); // Assurez-vous de terminer le script après la redirection
}

echo $page->render('register.html', []);