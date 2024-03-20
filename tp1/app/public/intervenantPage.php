<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($page->session->isConnected() && $page->session->hasRole('intervenant')) {

    $role = $page->session->get('role');
    $id_intervenant = $page->session->get('id');
    $interventions = $page->getInterventionsByIntervenant($id_intervenant);
    $statuts = $page->getStatut();
    $foot = "foot";
    echo $page->render('intervenantPage.html.twig', ['interventions' => $interventions, 'statuts' => $statuts, 'role'=> $role, 'foot' => $foot]);
} 
else 
{
    header('Location: index.php');
    exit();
}
