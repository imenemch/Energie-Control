<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

if(isset($_POST['send']))
{
    if(isset($_POST['send'])){
        $id = $_GET['id'];
        $commentaire = $_POST['commentaire'];
        $idSession = $page->session->get('id');

        $page->insertCommentaire('commentaire' ,[
            'id_intervention' => $id,
            'id_user' => $idSession,
            'infos' => $commentaire
        ]);
    }

echo $page->render('addCommentaire.html',[]);

}
else
{
    header('Location : index.php');
}
    