<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

// Récupérer l'ID de l'intervention 
$interventionId = $_GET['id'];

// Récupérer toutes les informations sur l'intervention
$interventionInfo = $page->getInterventionInfo($interventionId);


// Récupérer les commentaires pour cette intervention
$commentaires = $page->getCommentsForIntervention($interventionId);

// Afficher toutes les informations sur l'intervention

echo $page->render('infoInterventionClient.html',[
    'commentaires' => $commentaires,
    'interventions'=> $interventionInfo
]); 