<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

    if (isset($_GET['id_intervention']) && isset($_POST['commentaire'])) {
     
        $idIntervention = $_GET['id_intervention'];
        $commentaire = $_POST['commentaire'];

        $page->insertCommentaire('commentaire', [
            'id_intervention' => $idIntervention,
            'infos' => $commentaire
        ]);
        header('Location: addIntervention.php');
        exit;
    } else {
        echo "Erreur : PAS ASSEZ DE DONNEES";
    }


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<h2>Ajouter un commentaire</h2>

<form action="" method="post">
    <input type="hidden" name="id_intervention" value="{{ intervention.id_intervention }}">
    <label for="commentaire">Votre commentaire :</label><br>
    <textarea id="commentaire" name="commentaire" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Ajouter commentaire">
</form>

</body>
</html>
