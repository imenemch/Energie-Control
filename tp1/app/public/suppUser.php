<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if(isset($id))
    {
        $page->suppUser($id);
        $msg = "Utilisateur supprimé avec succès !!";
        header('Location: listeUser.php');
    }
    else
    {
        header('Location: index.php');
    }
   