<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $infosUser = $page->getInfosUser($id);


        if(isset($_POST['send']))
        {

            $page->updateUserInfos([
                'id' => $id,
                'email' => $_POST['email'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'adresse' => $_POST['adresse'],
                'tel' => $_POST['tel'],
                'role' => $_POST['role']
            ]);

            header("Location: modificationUser.php?id=$id");
            exit();
        }

        echo $page->render('modificationUser.html', ['infosUser' => $infosUser]);

    }
    else
    {
        header('Location: index.php');
    }


    }
    else
    {
        header('Location: index.php');
    }

    