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



// Récupérer les commentaires pour chaque intervention
foreach ($client_interventions as &$intervention) {
    
}

// Vérifier si un tri a été demandé
if (isset($_GET['sort'])) {
    $sortField = $_GET['sort'];
    // Trier les interventions en fonction du champ spécifié
    usort($client_interventions, function($a, $b) use ($sortField) {
        return $a[$sortField] <=> $b[$sortField];
    });
}


// Afficher la page d'accueil des clients
echo $page->render('listeClient.html.twig', [
    'interventions' => $client_interventions
]);
