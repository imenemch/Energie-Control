<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $id = $_GET['id'];
    if($id)
    {
         $infosUser = $page->getInfosUser($id);
    }
    else
    {
        header('Location: index.php');
    }

    if(isset($_POST['send']))
    {

        $page->updateUserInfos([
            'id' => $id,
            'email' => $_POST['email'],
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'adresse' => $_POST['adresse'],
            'tel' => $_POST['tel'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role']
        ]);

        header("Location: modificationUser.php?id=$id");
        exit();
    }
   
    echo $page->render('modificationUser.html', ['infosUser' => $infosUser]);
