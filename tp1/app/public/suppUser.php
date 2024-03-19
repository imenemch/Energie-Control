<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if(isset($id))
    {
        $page->suppUser($id);
        header('Location: listeUser.php');
        exit();
    }
    else
    {
        header('Location: index.php');
        exit();
    }
   