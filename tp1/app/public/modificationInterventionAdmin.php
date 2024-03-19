<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        if(isset($_GET['id']))
        {
             $id = $_GET['id'];
             $infosInterventions = $page->getInterventionInfoAdmin($id);
             $intervenantForIntevention = $page->getIntervenantByIntervention($id);
             $intervenants =$page->getIntervenant();
             $standardistes = $page->getAllStandardiste();
             $degres = $page->getDegre();
             $statuts = $page->getStatut();
            $role = $page->session->get('role');


            if(isset($_POST['send']))
            {
                $id_standardistes = $_POST['standardistes'];
                foreach($id_standardistes as $standardiste)
                {
                   $success1=  $page->updateInterventionInfosAdmin([
                         'id_intervention' => $id,
                         'id_standardiste' => $standardiste,
                         'id_statut' => $_POST['statut'],
                         'id_degre' => $_POST['degre'],
                         'description' => $_POST['description'],
                         'date' => $_POST['date'],
                         'heure' => $_POST['heure']
                     ]);
                }
            
                $success2 = $page->updateClientInfosAdmin([
                    'id' => $_POST['clientId'],
                    'nom' => $_POST['clientNom'],
                    'prenom'=> $_POST['clientPrenom'],
                    'adresse' => $_POST['adresse']
                ]);

                if(isset($_POST['intervenants']))
                {
                    $id_inter_users = $page->getIdInterUserForIntervention($id);
                    foreach($id_inter_users as $id_inter_user)
                    {
                        $success3 = $page->SupInterUser($id_inter_user);
                    }
                    $id_intervenants = $_POST['intervenants'];
                    foreach($id_intervenants as $id_intervenant)
                    {
                        $success4 = $page->insertInterUser('intervention_user',[
                            'id_intervenant' => $id_intervenant,
                            'id_intervention' => $id
                         ]);  
                    }     
                }
                header("Location: modificationInterventionAdmin.php?id=$id");
                exit();

            }
        }
        else
        {
            header('Location: index.php');
            exit();
        }

    
    
   
        echo $page->render('modificationInterventionAdmin.html', ['infosInterventions' => $infosInterventions, 
        'intervenants'=> $intervenants, 'standardistes'=> $standardistes, 'degres' => $degres, 'statuts' => $statuts, 
        'intervenantForInteventions'=>$intervenantForIntevention, 'role'=> $role]);


    }    
    else
    {
        header('Location: index.php');
        exit();
    }    