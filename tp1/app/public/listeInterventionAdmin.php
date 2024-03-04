<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $allInterventions = $page->getAllInterventionsAdmin();
    
   
    echo $page->render('listeInterventionAdmin.html.twig', ['allInterventions' => $allInterventions]);
