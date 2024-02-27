<?php

require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

        $intervenants =$page->getIntervenant();
        $degres =$page->getDegre();
        $statuts =$page->getStatut();
        $types =$page->getType();
        $id_standardiste = $page->session->get('id');
    
    if(isset($_POST['send']))
    {
         $description = $_POST['description'];
         $id_intervenants = $_POST['intervenants'];
         $id_degre = $_POST['degres'];
         $id_statut = $_POST['statuts'];
         $id_type = $_POST['types'];
         $date = $_POST['date'];
         $heure = $_POST['heure'];
       

        // Vérification de si l'email existe déjà dans users
        $user = $page->getUserByEmail([
            'email' => $_POST['email']
        ]);

       

        if(!$user){
            
            // Dans insertClient on fait en sorte de récupérer le dernier id insérer dans la table
            // Pour pas tout le temps appeler getUser
            $id_client = $page->insertClient('users', [
                'email' => $_POST['email'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'adresse' => $_POST['adresse'],
                'tel' => $_POST['tel']
            ]);

        }else
        {
            $id_client = $user['id'];
           
        }
       
        $id_intervention = $page->insertIntervention('intervention', [
            'id_client' => $id_client,
            'id_standardiste' => $id_standardiste,
            'id_statut' => $id_statut,
            'id_degre' => $id_degre,
            'id_type' => $id_type,
            'description' => $description,
            'date' => $date,
            'heure' => $heure
        ]);
       
        foreach($id_intervenants as $inter)
        {
            $page->insertInterUser('intervention_user', [
                'id_intervenant' => $inter,
                'id_intervention' => $id_intervention
            ]);
        }
        
        if(isset($_POST['commentaires']) && !empty($_POST['commentaires']))
        {
           $id_commentaire = $page->insertCommentaire('commentaire',[
               'id_intervention' => $id_intervention,
               'infos' => $_POST['commentaires']
           ]);
         
        }

        
        
    }

 echo $page->render('addIntervention.html', ['intervenants' => $intervenants, 
 'degres' => $degres, 'statuts' => $statuts, 'types' => $types]);

