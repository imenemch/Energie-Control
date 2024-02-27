<?php
require_once '../vendor/autoload.php';

use App\Page;
// use App\ClientIntervention;

$page = new Page();

// Vérifier si l'utilisateur est connecté en tant que client
if (!$page->session->isConnected() ) {
    header('location: login.php');
    exit();
}

// Obtenir l'ID de l'utilisateur connecté
$client_id = $page->session->get('id');

// Récupérer les interventions en cours du client
$client_interventions = $page->getClientInterventions($client_id);
var_dump($client_interventions);

// // Récupérer les commentaires pour chaque intervention
// foreach ($client_interventions as &$intervention) {
//     $intervention['commentaires'] = ClientIntervention::getCommentaires($intervention['id_intervention']);
// }

// Afficher la page d'accueil des clients
echo $page->render('home.html.twig', [
    'interventions' => $client_interventions
]);
