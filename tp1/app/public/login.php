<?php
require_once '../vendor/autoload.php';

use App\Page;
$page = new Page();
 
if ($page->session->isConnected()) {
    header('Location: index.php');
    exit();
} 
    $email = $page->session->get('email');
echo $page->render ('login.html.twig', ['email'=> $email]);
?>
