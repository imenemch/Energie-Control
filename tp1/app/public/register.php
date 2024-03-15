<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();
    $msg = false;
    if(isset($_POST['send']))
    {
        $success = $page->insertUsers('users', [
            'email' => $_POST['email'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'adresse' => $_POST['adresse'],
            'tel' => $_POST['tel'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        if(!$success)
        {
            $msg = "Inscription réussie, vous allez être redirigé !! ";
            header('Refresh: 3; URL=index.php');
        }
        else
        {
            $msg = "Une erreur est survenue lors de l'inscription";
            header('Refresh: 3; URL=index.php');
        }
    }
   
    echo $page->render('register.html.twig', ['msg' => $msg]);
