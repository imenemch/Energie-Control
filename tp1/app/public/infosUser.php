<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if($id)
    {
        $infosUsers = $page->getInfosUser($id);
       
    }
    
    
   
    echo $page->render('infosUser.html', ['infosUsers' => $infosUsers]);
