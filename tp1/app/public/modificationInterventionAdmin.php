<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];
    if($id)
    {
         $infosInterventions = $page->getInterventionInfoAdmin($id);
         $intervenantForIntevention = $page->getIntervenantByIntervention($id);
         $intervenants =$page->getIntervenant();
         $standardistes = $page->getAllStandardiste();
         $degres = $page->getDegre();
         $statuts = $page->getStatut();
        //  var_dump($infosInterventions);
        //  var_dump($intervenantForIntevention);
        var_dump($infosInterventions);


        if(isset($_POST['send']))
        {
            $id_standardistes = $_POST['standardistes'];
            foreach($id_standardistes as $standardiste)
            {
                 $page->updateInterventionInfosAdmin([
                     'id_intervention' => $id,
                     'id_standardiste' => $standardiste,
                     'id_statut' => $_POST['statut'],
                     'id_degre' => $_POST['degre'],
                     'description' => $_POST['description'],
                     'date' => $_POST['date'],
                     'heure' => $_POST['heure']
                 ]);
            }
        
            $id_intervenants = $_POST['intervenants'];
            $id_inter_users = $page->getIdInterUserForIntervention($id);
            
            foreach($id_inter_users as $key => $idInterUser) {
                // Vérifier si l'index existe dans le tableau des intervenants
                if(isset($id_intervenants[$key])) {
                    $inter = $id_intervenants[$key];
                    $page->updateIntervenantInfosAdmin([
                        'id_inter_user' => $idInterUser['id_inter_user'],
                        'id_intervenant' => $inter
                    ]);
                }
            }
            
            $page->updateClientInfosAdmin([
                'id' => $_POST['clientId'],
                'nom' => $_POST['clientNom'],
                'prenom'=> $_POST['clientPrenom'],
                'adresse' => $_POST['adresse']
            ]);
                
            // header("Location: modificationInterventionAdmin.php?id=$id");
            // exit();

    }
    }
    else
    {
        header('Location: index.php');
    }

    
    
   
    echo $page->render('modificationInterventionAdmin.html', ['infosInterventions' => $infosInterventions, 
    'intervenants'=> $intervenants, 'standardistes'=> $standardistes, 'degres' => $degres, 'statuts' => $statuts, 
    'intervenantForInteventions'=>$intervenantForIntevention]);
