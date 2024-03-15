<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $allUsers = $page->getAllUsers();
    
   
    echo $page->render('listeUser.html', ['allUsers' => $allUsers]);
