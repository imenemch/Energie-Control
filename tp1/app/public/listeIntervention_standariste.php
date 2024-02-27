<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$interventions = $page->getAllInterventionsStandardiste();

echo $page->render('listeIntervention.html.twig', ['interventions' => $interventions]);
