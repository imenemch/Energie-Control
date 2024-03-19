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
    $role = $page->session->get('role');

    if($infosInterventions) {
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientNom = $_POST['clientNom'];
            $clientPrenom = $_POST['clientPrenom'];
            $description = $_POST['description'];
            $statut_intervention = $_POST['statut'];
            $degre_intervention = $_POST['degre'];
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $clientId = $_POST['clientId'];
            $adresse = $_POST['adresse'];

            // Update des infos de l'intervention 
            $success1 = $page->updateInterventionInfoStandardiste([
                'id_intervention' => $id_intervention,
                'id_statut' => $statut_intervention,
                'id_degre' => $degre_intervention,
                'description' => $description,
                'date' => $date,
                'heure' => $heure
            ]);

            // Update des infos du client
            $success2 = $page->updateClientInfosAdmin([
                'id' => $clientId,
                'nom' => $clientNom,
                'prenom'=> $clientPrenom,
                'adresse' => $adresse
            ]);

            if(isset($_POST['intervenants']))
            {
                    $id_inter_users = $page->getIdInterUserForIntervention($id_intervention);
                    foreach($id_inter_users as $id_inter_user)
                    {
                        $success3 = $page->SupInterUser($id_inter_user);
                    }
                    $id_intervenants = $_POST['intervenants'];
                    foreach($id_intervenants as $id_intervenant)
                    {
                        $success4 = $page->insertInterUser('intervention_user',[
                            'id_intervenant' => $id_intervenant,
                            'id_intervention' => $id_intervention
                         ]);  
                    }     
                
                header("Location: updateIntervention.php?id=$id_intervention");
                exit();
            }
               
        }
    }
     else
    {
        header('Location: index.php');
        exit();
    }
} 
else
 {
    header('Location: index.php');
    exit();
}
echo $page->render('updateIntervention.html', ['infosInterventions' => $infosInterventions,'intervenants' => $intervenants, 'degres' => $degres,
'statuts' => $statuts, 'intervenantForInterventions' => $intervenantForIntevention, 'role'=> $role]);

?>
