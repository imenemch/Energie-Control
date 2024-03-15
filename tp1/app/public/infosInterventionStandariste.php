<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];

    if($id)
    {
        $interventions = $page->getInterventionInfoStandariste($id);
        $commentaires = $page->getCommentsForInterventionAdmin($id);

    }
    
    echo $page->render('infosInterventionStandariste.html.twig', ['interventions' => $interventions, 'commentaires' => $commentaires, 'commentaire' ]);