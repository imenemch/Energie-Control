<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($page->session->isConnected() && $page->session->hasRole('standardiste')) {

    $role = $page->session->get('role');
    $id_standardiste = $page->session->get('id');
    $interventions = $page->getInterventionsOfStandardiste($id_standardiste);
    echo $page->render('interventionStandaristes.html.twig', ['interventions' => $interventions, 'role'=> $role]);
} 
else 
{
    header('Location: index.php');
    exit();
}
