<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_GET['id'])) 
{
    $id_intervention = $_GET['id'];

    $infosInterventions = $page->getInterventionInfoAdmin($id_intervention);
    $intervenantForIntevention = $page->getIntervenantByIntervention($id_intervention);
    $intervenants =$page->getIntervenant();
    $degres = $page->getDegre();
    $statuts = $page->getStatut();

    if($infosInterventions) {
        // Je te laisse modifier la partie update en fonction des nouvelles variables dans le .html
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_client = $_POST['nom_client'];
            $statut_intervention = $_POST['statut_intervention'];
            $degre_intervention = $_POST['degre_intervention'];
            $description_intervention = $_POST['description_intervention'];

            $page->updateInterventionStandariste($id_intervention, $nom_client, $statut_intervention, $degre_intervention, $description_intervention);
            header('Location: interventionStandaristes.php');
            exit();
        }
    } else {
        header('Location: erreur.php');
        exit();
    }
} 
else
 {
    header('Location: index.php');
    exit();
}
echo $page->render('updateIntervention.html', ['infosInterventions' => $infosInterventions,'intervenants' => $intervenants, 'degres' => $degres,
'statuts' => $statuts, 'intervenantForInterventions' => $intervenantForIntevention]);

?>
