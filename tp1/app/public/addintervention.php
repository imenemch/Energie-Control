<?php

require_once '../vendor/autoload.php';

use App\Page;
 
 $page = new Page();

$intervenants =$page->getIntervenant();
$degres =$page->getDegre();
$statuts =$page->getStatut();
$id_standardiste = $page->session->get('id');
   
if(isset($_POST['send']))
{
$id_intervenants = $_POST['intervenants'];
var_dump($id_intervenants);
var_dump($_POST['degres']);
var_dump($_POST['statuts']);
var_dump($_POST['types']);
var_dump($id_standardiste);
// Vérification de si l'email existe déjà dans users
 $user = $page->getUserByEmail([
'email' => $_POST['email']
]);



if(!$user){
 // Dans insertClient on fait en sorte de récupérer le dernier id insérer dans la table
 // Pour pas tout le temps appeler getUser
$id_client = $page->insertClient('users', [
'email' => $_POST['email'],
'nom' => $_POST['nom'],
'prenom' => $_POST['prenom'],
'adresse' => $_POST['adresse'],
'tel' => $_POST['tel']
]);
var_dump($id_client);

}else
{$id_client = $user['id'];
var_dump($id_client);
}
 }
    
echo $page->render('addIntervention.html', ['intervenants' => $intervenants, 
'degres' => $degres, 'statuts' => $statuts, 'types' => $types]);