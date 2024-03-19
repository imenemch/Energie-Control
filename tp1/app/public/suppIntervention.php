<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_GET['id']))
{
    $id_intervention = $_GET['id'];

    $page->deleteIntervention($id_intervention);
    header('Location: listeInterventionAdmin.php');

}
else
{
    header('Location: index.php');
}
