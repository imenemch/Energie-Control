<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        $role = $page->session->get('role');
        $allInterventions = $page->getAllInterventionsAdmin();
        echo $page->render('listeInterventionAdmin.html.twig', ['allInterventions' => $allInterventions, 'role'=> $role]);

    }
    else
    {
        header('Location: index.php');
        exit();
    }
