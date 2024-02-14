<?php

require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $intervenants =$page->getIntervenant();
   
    if(isset($_POST['send']))
    {
        // $id_intervenants = $_POST['intervenants'];
        // Vérification de si l'email existe déjà dans users
        
            // insertion dans la table statut
            $page->insertStatut('statut', [
                'statut' => $_POST['statut']
            ]);

            // insertion dans la table degre
            $page->insertDegre('degre', [
                'libelle' => $_POST['degre']
            ]);

            if($_POST['commentaires'])
            {
                $page->insertCommentaire('commentaire', [
                    'infos' => $_POST['commentaires']
                ]);
            }

        $user = $page->getUserByEmail([
            'email' => $_POST['email']
        ]);

        $id_standardiste = $page->session->get('id');
       

        if(!$user){
            
            $page->insertClient('users', [
                'email' => $_POST['email'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'adresse' => $_POST['adresse'],
                'tel' => $_POST['tel']
            ]);

            $client = $page->getUserByEmail([
                'email' => $_POST['email']
            ]);

            $id_client = $client['id'];
            
        }
       

        
        
    }

 echo $page->render('intervention.html', ['intervenants' => $intervenants]);