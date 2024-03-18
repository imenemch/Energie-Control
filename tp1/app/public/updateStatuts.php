<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if($_GET['id'])
{
    $idInter = $_GET['id'];
    $idStatut = $_GET['idStatut'];
    $page->updateInterventionStatus($idInter, $idStatut);
    header('Location: intervenantPage.php');
}
else
{
    header('Location: index.php');
}

?>
