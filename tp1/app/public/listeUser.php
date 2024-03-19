<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        $role = $page->session->get('role');
        $allUsers = $page->getAllUsers();
        echo $page->render('listeUser.html', ['allUsers' => $allUsers, 'role'=> $role]);
    }
    else
    {
        header('Location: index.php');
        exit();
    }

