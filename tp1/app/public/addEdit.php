<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

// Récupérer l'ID de l'intervention 
$interventionId = $_GET['id'];

// Vérifier si des données de commentaire sont soumises
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    // Récupérer le commentaire soumis
    $nouveauCommentaire = $_POST['comment'];
    
    // Enregistrer le nouveau commentaire dans la base de données
    $page->ajouterCommentaire($interventionId, $nouveauCommentaire);
    
    // Redirection vers la même page pour éviter la soumission multiple
    header("Location: addEdit.php?id=$interventionId");
    exit();
}

// Récupérer toutes les informations sur l'intervention
$interventionInfo = $page->getInterventionInfo($interventionId);

// Récupérer les commentaires pour cette intervention
$commentaires = $page->getCommentsForIntervention($interventionId);

// Afficher toutes les informations sur l'intervention
echo $page->render('infoInterventionClient.html',[
    'commentaires' => $commentaires,
    'interventions'=> $interventionInfo
]);
