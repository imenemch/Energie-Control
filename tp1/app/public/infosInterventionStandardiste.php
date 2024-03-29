<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->hasRole('standardiste'))
    {
        $role = $page->session->get('role');
       if($_GET['id'])
       {
           $id = $_GET['id'];
           $interventions = $page->getInterventionInfoAdmin($id);
           $commentaires = $page->getCommentsForInterventionAdmin($id);
           $idSession = $page->session->get('id');
   
           if(isset($_POST['send']))
           {
               $comment = $_POST['comment'];
               $page->insertCommentaire('commentaire', [
                   'id_intervention' => $id,
                   'id_user' => $idSession,
                   'infos' => $comment
               ] );
              
               header("Location: infosInterventionStandardiste.php?id=$id");
               exit();
           }
       }
       else
       {
           header('Location: index.php');
       }    
      
       echo $page->render('infosInterventionStandardiste.html.twig', ['interventions' => $interventions, 
                           'commentaires' => $commentaires, 'role' => $role]);
    }
    else
    {
        header('Location: index.php');
    }
       
   