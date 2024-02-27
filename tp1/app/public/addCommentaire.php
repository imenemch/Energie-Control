<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_POST['send'])){
    $id = $_GET['id'];
    $commentaire = $_POST['commentaire'];

    $page->insertCommentaire('commentaire' ,[
        'id_intervention' => $id,
        'infos' => $commentaire
    ]);
}

echo $page->render('addCommentaire.html',[]);
