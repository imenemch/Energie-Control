<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

// Vérifiez d'abord si un formulaire a été soumis
if(isset($_POST['update']))
{
    // Récupérez les données du formulaire
    $id_intervention = $_POST['id_intervention'];
    $description = $_POST['description'];
    $id_intervenants = $_POST['intervenants'];
    $id_degre = $_POST['degres'];
    $id_statut = $_POST['statuts'];
    $id_type = $_POST['types'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    // Mettre à jour l'intervention dans la base de données
    $page->updateIntervention($id_intervention, [
        'description' => $description,
        'id_intervenants' => $id_intervenants,
        'id_degre' => $id_degre,
        'id_statut' => $id_statut,
        'id_type' => $id_type,
        'date' => $date,
        'heure' => $heure
    ]);


}
