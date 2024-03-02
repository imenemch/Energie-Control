<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_GET['id'])) {
    $id_intervention = $_GET['id'];

    $intervention = $page->getInterventionDetails($id_intervention);

    if($intervention) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];

            $page->updateIntervention($id_intervention, $description);
            header('Location: listeInterventions.php');
            exit();
        }
    } else {
        header('Location: erreur.php');
        exit();
    }
} else {
    header('Location: erreur.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Intervention</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Modifier Intervention</h2>
        <form action="" method="POST">
            <div>
                <label for="description">Description de l'intervention :</label><br>
                <textarea id="description" name="description" rows="4" cols="50" required><?php echo $intervention['description']; ?></textarea>
            </div>
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>
</html>
