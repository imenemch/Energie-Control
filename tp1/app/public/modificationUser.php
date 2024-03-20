<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();
    $msg = false;

    if($page->session->isConnected() && $page->session->hasRole('admin'))
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];

            $infosUser = $page->getInfosUser($id);
            $role = $page->session->get('role');



            if(isset($_POST['send']))
            {

                $role = strtolower($_POST['role']);
               $success = $page->updateUserInfos([
                    'id' => $id,
                    'email' => $_POST['email'],
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'adresse' => $_POST['adresse'],
                    'tel' => $_POST['tel'],
                    'role' => $role
                ]);

                if($success)
                {
                    $msg = "Une erreur est survenue lors de la modification";
                    header("Refresh: 1; URL=modificationUser.php?id=$id");
                    exit();
                }
                else
                {
                    $msg = "Modification réussie !!";
                    header("Refresh: 1; URL=modificationUser.php?id=$id");
                }

            }

            echo $page->render('modificationUser.html.twig', ['infosUser' => $infosUser, 'msg'=> $msg, 'role' => $role]);

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

    