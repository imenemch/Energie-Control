<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Session;

$page = new Page();
$session = new Session();

if ($session->isConnected()) {

    $id_standardiste = $session->get('id');
    $interventions = $page->getInterventionsOfStandardiste($id_standardiste);
    echo $page->render('interventionstandaristes.html.twig', ['interventions' => $interventions]);
} else {
   
    header('Location: login.php');
    exit();
}
