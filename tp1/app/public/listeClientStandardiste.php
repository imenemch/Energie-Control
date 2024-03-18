<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('standardiste'))
    {
        $allClients = $page->getAllClient();
        echo $page->render('listeClientStandardiste.html', ['allClients' => $allClients]);
    }
    else
    {
        header('Location: index.php');
        exit();
    }

