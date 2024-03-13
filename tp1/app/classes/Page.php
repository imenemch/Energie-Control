<?php

namespace App;

use App\Session;
use PDO; // Ajoutez cette ligne pour importer la classe PDO


class Page
{
    private \Twig\Environment $twig;
    private $pdo;
    public $session;

    function __construct()
    {
        $this->session = new Session();
        
        try {
            // Utilisez la classe PDO avec le chemin complet
            $this->pdo = new PDO('mysql:host=mysql;dbname=b2-paris', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',
            'debug' => true
        ]);
    }


    public function insertUsers(string $table_name, array $data) 
    {
        $sql = "INSERT INTO " . $table_name. " (email, nom, prenom, adresse, tel, password) VALUES 
        (:email, :nom, :prenom, :adresse, :tel, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function insertClient(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (email, nom, prenom, adresse, tel) VALUES 
        (:email, :nom, :prenom, :adresse, :tel)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $lastInsertedId = $this->pdo->lastInsertId();
    }

    public function insertIntervention(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (id_client, id_standardiste, id_statut, id_degre,
        id_type, description, date, heure) VALUES(:id_client, :id_standardiste, :id_statut, :id_degre,
        :id_type, :description, :date, :heure)"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $lastInsertedId = $this->pdo->lastInsertId();
    }

    public function updateInterventionInfosAdmin(array $data)
    {
        $sql = "UPDATE intervention SET id_standardiste = :id_standardiste,
                id_statut = :id_statut, id_degre = :id_degre, description = :description,
                date = :date, heure = :heure WHERE id_intervention = :id_intervention";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateClientInfosAdmin(array $data)
    {
        $sql = "UPDATE users SET nom = :nom, prenom =:prenom, adresse = :adresse WHERE id = :id"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function updateIntervenantInfosAdmin(array $data)
    {
        $sql = "UPDATE intervention_user SET id_intervenant = :id_intervenant WHERE id_inter_user = :id_inter_user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getIdInterUserForIntervention($id)
    {
        $sql = "SELECT id_inter_user FROM intervention_user WHERE id_intervention = :id_intervention";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_intervention' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIdUserByCommentaire($interventionId)
    {
        $sql = "SELECT id_user FROM commentaire WHERE id_intervention = :interventionId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':interventionId' => $interventionId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertCommentaire(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (id_intervention, id_user, infos) VALUES (:id_intervention , :id_user , :infos)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $lastInsertedId = $this->pdo->lastInsertId();
    }

    public function insertInterUser(string $table_name, array $data)
    {
        $sql = "INSERT INTO ". $table_name ." (id_intervenant, id_intervention) VALUES (:id_intervenant, :id_intervention)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function getUserByEmail(array $data)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function getInfosUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateUserInfos(array $data)
    {
        $sql = "UPDATE users SET email = :email, nom = :nom, prenom =:prenom, adresse = :adresse, tel =:tel, role= :role WHERE id = :id"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function suppUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function getAllInterventions()
{
    $sql = "SELECT DISTINCT i.*,
                              u.nom AS nomClient,
                              u.prenom AS prenomClient,
                              u_intervenant.nom AS nomIntervenant,
                              u_intervenant.prenom AS penomIntervenant,
                              u_standardiste.nom AS nomStandardiste,
                              u_standardiste.prenom AS prenomStandardiste, 
                              s.statut AS statutIntervention,
                              d.libelle AS degreIntervention
                FROM intervention AS i
                LEFT JOIN users AS u ON i.id_client = u.id 
                LEFT JOIN intervention_user AS iu ON i.id_intervention = iu.id_intervention
                LEFT JOIN users AS u_intervenant ON iu.id_intervenant = u_intervenant.id
                LEFT JOIN users AS u_standardiste ON i.id_standardiste = u_standardiste.id
                LEFT JOIN statut AS s ON i.id_statut = s.id_statut
                LEFT JOIN degre AS d ON i.id_degre = d.id_degre";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getAllInterventionsAdmin()
{
    $sql = "SELECT i.id_intervention, 
                   i.id_client, 
                   i.id_standardiste, 
                   i.id_statut, 
                   i.id_degre, 
                   i.id_type, 
                   i.description, 
                   i.date, 
                   i.heure, 
                   u.nom AS nomClient, 
                   u.prenom AS prenomClient, 
                   GROUP_CONCAT(DISTINCT CONCAT(u_intervenant.nom, ' ', u_intervenant.prenom) SEPARATOR ', ') AS intervenants, 
                   u_standardiste.nom AS nomStandardiste, 
                   u_standardiste.prenom AS prenomStandardiste, 
                   s.statut AS statutIntervention, 
                   d.libelle AS degreIntervention
            FROM intervention AS i
            LEFT JOIN users AS u ON i.id_client = u.id 
            LEFT JOIN intervention_user AS iu ON i.id_intervention = iu.id_intervention
            LEFT JOIN users AS u_intervenant ON iu.id_intervenant = u_intervenant.id
            LEFT JOIN users AS u_standardiste ON i.id_standardiste = u_standardiste.id
            LEFT JOIN statut AS s ON i.id_statut = s.id_statut
            LEFT JOIN degre AS d ON i.id_degre = d.id_degre
            GROUP BY i.id_intervention";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getInterventionInfoAdmin($id)
{
    $sql = "SELECT i.id_intervention, 
                   i.id_client, 
                   i.id_standardiste, 
                   i.id_statut, 
                   i.id_degre, 
                   i.id_type, 
                   i.description, 
                   i.date, 
                   i.heure, 
                   u.nom AS nomClient, 
                   u.prenom AS prenomClient,
                   u.adresse AS adresse,
                   GROUP_CONCAT(DISTINCT CONCAT(u_intervenant.nom, ' ', u_intervenant.prenom) SEPARATOR ', ') AS intervenants, 
                   u_standardiste.nom AS nomStandardiste, 
                   u_standardiste.prenom AS prenomStandardiste, 
                   s.statut AS statutIntervention, 
                   d.libelle AS degreIntervention
            FROM intervention AS i
            LEFT JOIN users AS u ON i.id_client = u.id 
            LEFT JOIN intervention_user AS iu ON i.id_intervention = iu.id_intervention
            LEFT JOIN users AS u_intervenant ON iu.id_intervenant = u_intervenant.id
            LEFT JOIN users AS u_standardiste ON i.id_standardiste = u_standardiste.id
            LEFT JOIN statut AS s ON i.id_statut = s.id_statut
            LEFT JOIN degre AS d ON i.id_degre = d.id_degre
            WHERE i.id_intervention = :id_intervention
            GROUP BY i.id_intervention";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id_intervention' => $id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getIntervenantByIntervention($id)
{
    $sql = "SELECT id_intervenant FROM intervention_user WHERE id_intervention = :id_intervention";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_intervention' => $id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
// Cette méthode prendra l'ID de l'intervention 
// Elle exécutera une requête SQL pour récupérer les commentaires correspondants à cet ID d'intervention.
// Elle renverra ensuite les commentaires récupérés.

public function getCommentsForIntervention($interventionId)
{
    $sql = "SELECT c.*, u.nom AS user_nom, u.prenom AS user_prenom, u.role AS user_role
            FROM commentaire c
            INNER JOIN users u ON c.id_user = u.id
            WHERE c.id_intervention = :interventionId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':interventionId' => $interventionId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getInterventionInfo($interventionId)
{
    $sql = "SELECT intervention.*, 
                   statut.statut AS nom_statut, 
                   degre.libelle AS nom_degre,
                   CONCAT(users.nom, ' ', users.prenom) AS nom_intervenant
            FROM intervention
            LEFT JOIN statut ON intervention.id_statut = statut.id_statut
            LEFT JOIN degre ON intervention.id_degre = degre.id_degre
            LEFT JOIN intervention_user ON intervention.id_intervention = intervention_user.id_intervention
            LEFT JOIN users ON intervention_user.id_intervenant = users.id
            WHERE intervention.id_intervention = :interventionId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':interventionId' => $interventionId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getCommentsForIntervention($interventionId)
{
    $sql = "SELECT commentaire.*, 
                   CONCAT(users.nom, ' ', users.prenom) AS nom_auteur_commentaire,
                   users.role AS role_auteur_commentaire
            FROM commentaire
            LEFT JOIN users ON commentaire.id_user = users.id
            WHERE commentaire.id_intervention = :interventionId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':interventionId' => $interventionId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}



public function getInterventionsByID($interventions)
{
    // Tableau pour stocker les interventions par ID
    $interventionsByID = [];

    // Parcourir le tableau d'interventions
    foreach ($interventions as $intervention) {
        $interventionId = $intervention['id_intervention'];
        // Vérifier si l'intervention n'existe pas déjà dans le tableau $interventionsByID
        if (!isset($interventionsByID[$interventionId])) {
            // Ajouter l'intervention au tableau avec son ID comme clé
            $interventionsByID[$interventionId] = $intervention;
        }
    }

    // Retourner le tableau des interventions par
    return $interventionsByID;
}


public function ajouterCommentaire($interventionId, $commentaire, $userId, $date)
{
    // Insérer le commentaire avec la date et l'ID de l'utilisateur dans la base de données
    $sql = "INSERT INTO commentaire (id_intervention, id_user, infos, date) VALUES (:interventionId, :id_user, :commentaire, :date)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':interventionId' => $interventionId, ':id_user' => $userId, ':commentaire' => $commentaire, ':date' => $date]);
}




// Fonction pour récupérer toutes les interventions avec les détails nécessaires
public function getAllInterventionsStandardiste()
{
    $sql = "SELECT i.id_intervention, u.nom AS nom_client, u.prenom AS prenom_client, 
    s.statut AS nom_statut, d.libelle AS nom_degre, 
    i.description AS description_intervention
FROM intervention AS i
JOIN users AS u ON i.id_client = u.id
JOIN statut AS s ON i.id_statut = s.id_statut
JOIN degre AS d ON i.id_degre = d.id_degre";

$stmt = $this->pdo->prepare($sql);
$stmt->execute();
return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

//Fonction des interventions de chaque standariste (propre à lui )
public function getInterventionsOfStandardiste($id_standardiste)
{
    $sql = "SELECT i.id_intervention, u.nom AS nom_client, u.prenom AS prenom_client, 
                   s.statut AS nom_statut, d.libelle AS nom_degre, 
                   i.description AS description_intervention
            FROM intervention AS i
            JOIN users AS u ON i.id_client = u.id
            JOIN statut AS s ON i.id_statut = s.id_statut
            JOIN degre AS d ON i.id_degre = d.id_degre
            WHERE i.id_standardiste = :id_standardiste";
            
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_standardiste' => $id_standardiste]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

//méthode pour supprimer une intervention
public function deleteIntervention($id_intervention)
{
    try {
        $sql = "DELETE FROM intervention WHERE id_intervention = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_intervention]);
    } catch (PDOException $e) {
        // Gérer l'erreur, par exemple en affichant un message ou en enregistrant dans un fichier de logs
        echo "Erreur lors de la suppression de l'intervention : " . $e->getMessage();
    }
}
// fin de la méthode ; oui j'ai pas envie que ça se mélange mdr

// méthode pour update une intervention


public function getInterventionDetails($id_intervention)
{
    try {
        $sql = "SELECT * FROM intervention WHERE id_intervention = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_intervention]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des détails de l'intervention : " . $e->getMessage();
        return null; 
    }
}

public function updateInterventionStandariste($id_intervention, $nom_client, $statut_intervention, $degre_intervention, $description_intervention)
{
    try {
        $sql = "UPDATE intervention SET 
                                    nom_client = ?, 
                                    statut_intervention = ?, 
                                    degre_intervention = ?, 
                                    description_intervention = ? 
                                    WHERE id_intervention = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nom_client, $statut_intervention, $degre_intervention, $description_intervention, $id_intervention]);
        return true; // Retourner true si la mise à jour a réussi
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de l'intervention : " . $e->getMessage();
        return false; // et false dans le cas contraire c'est simple non?? :)
    }
}


// fin de la méthode les loulous
     public function getAllUsers()
    {
        $sql = "SELECT * FROM users WHERE role != 'admin'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllStandardiste()
    {
        $sql = "SELECT * FROM users WHERE role = 'standardiste'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIntervenant()
    {
        $sql = "SELECT * FROM users WHERE role = 'intervenant'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getStatut()
    {
        $sql = "SELECT * FROM statut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Fonction qui récupère les degrés dans la table degré
    public function getDegre()
    {
        $sql = "SELECT * FROM degre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Fonction qui récupère les types dans la table type
    public function getType()
    {
        $sql = "SELECT * FROM type";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function render(string $name, array $data) :string
    {
        $templateName = $name . '.twig';
        return $this->twig->render($name, $data);// Rendu du template Twig avec les données fournies
    }

   

    
}