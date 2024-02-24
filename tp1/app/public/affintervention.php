<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();


if(isset($_GET['id']))
{
    $id_intervention = $_GET['id'];
    $intervention = $page->getInterventionById($id_intervention);

    if($intervention)
    {
        // Affichage les détails de l'intervention
        echo "<h1>Détails de l'intervention</h1>";
        echo "<p>ID : " . $intervention['id'] . "</p>";
        echo "<p>Description : " . $intervention['description'] . "</p>";
    }
    else
    {
        echo "Intervention non trouvée.";
    }
}
else
{
    echo "ID d'intervention manquant dans l'URL.";
}
