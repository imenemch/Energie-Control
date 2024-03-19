<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($page->session->isConnected() && $page->session->hasRole('intervenant')) {

    $role = $page->session->get('role');
    $id_intervenant = $page->session->get('id');
    $interventions = $page->getInterventionsByIntervenant($id_intervenant);
    $statuts = $page->getStatut();
    echo $page->render('intervenantPage.html', ['interventions' => $interventions, 'statuts' => $statuts, 'role'=> $role]);
} 
else 
{
    header('Location: index.php');
    exit();
}
