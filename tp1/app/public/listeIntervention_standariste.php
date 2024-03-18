<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if($page->session->isConnected() && $page->session->hasRole('standardiste'))
{
    $interventions = $page->getAllInterventionsStandardiste();
    echo $page->render('listeInterventionStandardiste.html.twig', ['interventions' => $interventions]);
}
else
{
    header('Location : index.php');
    exit();
}
