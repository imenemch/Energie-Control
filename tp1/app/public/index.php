<?php
    
    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $page->session->get('user');

    $msg = false;

    if(isset($_POST['send'])){
        $user = $page->getUserByEmail([
            'email' => $_POST['email']
        ]);

        if(!$user){
            $msg = "Email ou mot de passe incorrect !";
        }else{
            if(!password_verify($_POST['password'], $user['password'])){
                $msg = "Email ou mot de passe incorrect !";
            }else
            {
                $page->session->add('email', $_POST['email']);
                $page->session->add('id', $user['id']);
                $page->session->add('role', $user['role']);

                header('location: login.php');
            }
        }
    }
    echo $page->render('index.html.twig', [
        'msg' => $msg]);
