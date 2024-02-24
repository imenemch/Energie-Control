<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $clients = $page->getAllClient();
    
    
   
    echo $page->render('listeUser.html.twig', ['clients' => $clients]);
