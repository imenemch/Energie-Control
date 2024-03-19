<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if($page->session->hasRole('admin'))
    {

        if($_GET['id'])
        {
            $id = $_GET['id'];
            $infosUsers = $page->getInfosUser($id);
            $role = $page->session->get('role');
        }
    
        echo $page->render('infosUser.html', ['infosUsers' => $infosUsers, 'role' => $role]);

    }
    else
    {
        header('Location: index.php');
    }