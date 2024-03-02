<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;

$page = new Page();
$session = new Session();

// Vérifiez d'abord si l'utilisateur est connecté
if ($session->isConnected()) {
    // Récupérez l'identifiant du standardiste connecté à partir de la session
    $id_standardiste = $session->get('id'); // Vous devez stocker l'ID du standardiste lors de la connexion dans la session

    // Récupérez les interventions du standardiste
    $interventions = $page->getInterventionsOfStandardiste($id_standardiste);

    // Affichez les interventions
    echo $page->render('interventionstandaristes.html.twig', ['interventions' => $interventions]);
} else {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}
