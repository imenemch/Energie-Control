<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        $role = $page->session->get('role');
        $allInterventions = $page->getAllInterventionsAdmin();
        $foot = "foot";
        echo $page->render('listeInterventionAdmin.html.twig', [
            'allInterventions' => $allInterventions, 
            'role'=> $role,
            'foot' => $foot
        ]);

    }
    else
    {
        header('Location: index.php');
        exit();
    }
