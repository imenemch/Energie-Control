<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['interventionId'], $_POST['newStatutId'])) {
        $interventionId = $_POST['interventionId'];
        $newStatutId = $_POST['newStatutId'];

        // Appelez la méthode pour mettre à jour le statut de l'intervention
        $success = $page->updateInterventionStatus($interventionId, $newStatutId);

        if ($success) {
            // Mise à jour réussie
            http_response_code(200);
            exit;
        } else {
            // Erreur lors de la mise à jour
            http_response_code(500);
            exit;
        }
    }
}

// Requête incorrecte
http_response_code(400);
exit;
?>
