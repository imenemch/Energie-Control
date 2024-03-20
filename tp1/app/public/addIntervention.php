<?php

require_once '../vendor/autoload.php';

    use App\Page;
    $page = new Page();
    $msg = false;

    if($page->session->hasRole('admin') || $page->session->hasRole('standardiste'))
    {
            $intervenants =$page->getIntervenant();
            $degres =$page->getDegre();
            $statuts =$page->getStatut();
            $types =$page->getType();
            $id_standardiste = $page->session->get('id');
            $role = $page->session->get('role');

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

        
            // S'il n'existe pas, insertion du client dans la BDD
            if(!$user){
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
               $success= $page->insertInterUser('intervention_user', [
                    'id_intervenant' => $inter,
                    'id_intervention' => $id_intervention
                ]);
            }

            if(isset($_POST['commentaires']))
            {
               $id_commentaire = $page->insertCommentaire('commentaire',[
                   'id_intervention' => $id_intervention,
                   'id_user' => $id_standardiste,
                   'infos' => $_POST['commentaires'],
               ]);
           
            }

            if($id_intervention && $success)
            {
                $msg = "Une erreur est survenue lors de la création de l'intervention";
                header("Refresh: 1; URL=addIntervention.php");
            }
            else
            {
                $msg= "Intervention créée avec succès !! ";
                header("Refresh: 1; URL=addIntervention.php");
            }

        }

    echo $page->render('addIntervention.html.twig', ['intervenants' => $intervenants, 
    'degres' => $degres, 'statuts' => $statuts, 'types' => $types, 'msg' => $msg, 'role'=> $role]);

    }
    else
    {
        header('Location: index.php');
    }
    
        