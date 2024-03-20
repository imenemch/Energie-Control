<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('standardiste'))
    {
        $role = $page->session->get('role');
        $allClients = $page->getAllClient();
        $foot = "foot";
        echo $page->render('listeClientStandardiste.html.twig', ['allClients' => $allClients, 'role'=> $role, 'foot' => $foot]);
    }
    else
    {
        header('Location: index.php');
        exit();
    }

