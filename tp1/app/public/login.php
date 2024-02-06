<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
 
if (!$page->session->isConnected('user')) {
    header('Location: index.php');
    echo "Connexion échouée !";
    exit();
} 
    $email->session -> get('email');


echo $page -> render ('login.html.twig', ['email'=> $email]);
?>
