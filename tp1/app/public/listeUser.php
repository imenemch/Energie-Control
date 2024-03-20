<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        $role = $page->session->get('role');
        $allUsers = $page->getAllUsers();
        $foot = "foot";
        echo $page->render('listeUser.html.twig', [
            'allUsers' => $allUsers, 
            'role'=> $role,
            'foot' => $foot
        ]);
    }
    else
    {
        header('Location: index.php');
        exit();
    }

