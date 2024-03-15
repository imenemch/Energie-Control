<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($page->session->isConnected() && $page->session->hasRole('intervenant')) {

    $id_intervenant = $page->session->get('id');
    $interventions = $page->getInterventionsByIntervenant($id_intervenant);
    echo $page->render('intervenantPage.html.twig', ['interventions' => $interventions]);
} 
else 
{
    header('Location: index.php');
    exit();
}
