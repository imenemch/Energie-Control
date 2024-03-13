<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if($id)
    {
        $interventions = $page->getInterventionInfoStandariste($id);
        $commentaires = $page->getCommentsForInterventionStandardiste($id);

    }
    
    
    echo $page->render('infosInterventionIntervention.html.twig', ['interventions' => $interventions, 'commentaires' => $commentaires, 'commentaire' ]);