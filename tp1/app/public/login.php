<?php
require_once '../vendor/autoload.php';

use App\Page;
$page = new Page();
 
if ($page->session->isConnected()) {
    header('Location: index.php?msg=Vous ne passerez pas !!');
    exit();
} 
    $email = $page->session->get('email');
    $idSession = $page->session->get('id');
echo $page->render ('login.html.twig', ['email'=> $email]);
?>
