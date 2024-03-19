<?php
require_once '../vendor/autoload.php';


use App\Page;

$page = new Page();

if($page->session->isConnected() && $page->session->hasRole('client'))
{
    $role = $page->session->get('role');
    // Récupérer toutes les interventions clients de la base de données
    $client_interventions = $page->getAllInterventions();

    // Créer un tableau associatif pour stocker les interventions par ID
    $interventionsByID = [];

    // Récupérer les commentaires pour chaque intervention et les associer
    foreach ($client_interventions as $intervention) {
        // Récupérer les informations de l'intervention
        $interventionInfo = $page->getInterventionInfo($intervention['id_intervention']);

        // Récupérer les commentaires pour l'intervention
        $interventionComments = $page->getCommentsForIntervention($intervention['id_intervention']);

        // Ajouter les informations de l'intervention au tableau
        $interventionsByID[$intervention['id_intervention']] = $interventionInfo[0]; 

        // Ajouter les commentaires à l'intervention
        $interventionsByID[$intervention['id_intervention']]['comments'] = $interventionComments;
    }

    // Convertir le tableau associatif en un simple tableau pour l'affichage
    $client_interventions = array_values($interventionsByID);

    // Afficher la page d'accueil des clients
    echo $page->render('listeClient.html.twig', [
        'interventions' => $client_interventions,
        'role'=> $role
    ]);


}
else
{
    header('Location: index.php');
    exit();
}