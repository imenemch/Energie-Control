<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if($page->session->hasRole('client'))
{
    // Récupérer l'ID de l'intervention 
    $interventionId = $_GET['id'];
    $role = $page->session->get('role');

    // Vérifier si des données de commentaire sont soumises
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
        // Récupérer le commentaire soumis
        $nouveauCommentaire = $_POST['comment'];

        // Récupérer la date et l'heure actuelles
        $dateAjout = date("Y-m-d H:i:s");

        // Enregistrer le nouveau commentaire dans la base de données avec la date et l'heure
        $page->ajouterCommentaire($interventionId, $nouveauCommentaire, $page->session->get('id'), $dateAjout);

        // Redirection vers la même page pour éviter la soumission multiple
        header("Location: infoClient.php?id=$interventionId");
        exit();
    }
    
    // Récupérer toutes les informations sur l'intervention
    $interventionInfo = $page->getInterventionInfo($interventionId);

    // Récupérer les commentaires pour cette intervention
    $commentaires = $page->getCommentsForIntervention($interventionId);

    // Afficher toutes les informations sur l'intervention
    echo $page->render('infoInterventionClient.html.twig',[
        'commentaires' => $commentaires,
        'interventions'=> $interventionInfo,
        'role' => $role
    ]);

}
else
{
    header('Location: index.php');
}