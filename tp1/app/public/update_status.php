<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_intervention"], $_POST["new_statut_id"])) {
    $idIntervention = $_POST["id_intervention"];
    $newStatutId = $_POST["new_statut_id"];

    // Appel à votre méthode pour mettre à jour le statut de l'intervention
    $success = $page->updateInterventionStatus($idIntervention, $newStatutId);

    if ($success) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    // Redirection avec un message d'erreur si les données POST ne sont pas correctement définies
    echo json_encode(array("success" => false, "error_message" => "Veuillez fournir l'identifiant de l'intervention et le nouveau statut."));
}
?>
