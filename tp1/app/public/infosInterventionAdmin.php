<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if($id)
    {
        $interventions = $page->getInterventionInfoAdmin($id);
        $commentaires = $page->getCommentsForIntervention($id);
    }
    
    
   
    echo $page->render('infosInterventionAdmin.html.twig', ['interventions' => $interventions, 'commentaires' => $commentaires]);
