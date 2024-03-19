<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if (isset($_GET['id'])) {
    $id_intervention = $_GET['id'];

    // Supprimer l'intervention
    $page->deleteIntervention($id_intervention);

    // Redirection après la suppression
    if (isset($_GET['redirect'])) {
        $redirect = $_GET['redirect'];
        header("Location: $redirect");
        exit();
    } else {
        header("Location: interventionStandaristes.php");
        exit();
    }
} else {
    header('Location: interventionStandaristes.php');
    exit();
}
?>
