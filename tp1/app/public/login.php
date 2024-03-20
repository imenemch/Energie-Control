<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if (!$page->session->isConnected()) {
    header('Location: index.php?msg=Vous ne passerez pas !!');
    exit();
}

$email = $page->session->get('email');
$role = $page->session->get('role'); 
$foot = "foot";
echo $page->render('login.html.twig', [
    'email' => $email, 
    'role' => $role,
    'foot' => $foot
]);
?>
