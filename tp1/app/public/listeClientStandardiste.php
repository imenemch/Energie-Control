<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('standardiste'))
    {
        $role = $page->session->get('role');
        $allClients = $page->getAllClient();
        echo $page->render('listeClientStandardiste.html', ['allClients' => $allClients, 'role'=> $role]);
    }
    else
    {
        header('Location: index.php');
        exit();
    }

