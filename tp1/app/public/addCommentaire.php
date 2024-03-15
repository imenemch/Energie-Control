<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();
    $msg = false;

if(isset($_GET['id']))
{
    if(isset($_POST['send'])){
        $id = $_GET['id'];
        $commentaire = $_POST['commentaire'];
        $idSession = $page->session->get('id');

        $insertion = $page->insertCommentaire('commentaire' ,[
            'id_intervention' => $id,
            'id_user' => $idSession,
            'infos' => $commentaire
        ]);

        if($insertion)
        {
            $msg = "Commentaire ajouté avec succès !!";
        }
        else
        {
            $msg = "Une erreur est survenue lors de l'ajout du commentaire";
        }
    }

    echo $page->render('addCommentaire.html',['msg'=> $msg]);

}
else
{
    header('Location : index.php');
}
    