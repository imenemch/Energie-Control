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

    // public function executeQuery(string $query) {
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // }

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

    public function insertCommentaire(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (id_intervention, infos) VALUES (:id_intervention , :infos)";
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
        $sql = "UPDATE users SET email = :email, nom = :nom, prenom =:prenom, adresse = :adresse, tel =:tel, 
        password = :password, role= :role WHERE id = :id"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function suppUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function getClientInterventions()
    {
        $sql = "SELECT i.*, 
                       u.nom AS nom_client, 
                       u.prenom AS prenom_client, 
                       u_intervenant.nom AS nom_intervenant, 
                       u_intervenant.prenom AS prenom_intervenant,
                       s.statut AS nom_statut, 
                       d.libelle AS nom_degre, 
                       c.infos AS commentaire
                FROM intervention AS i
                LEFT JOIN users AS u ON i.id_client = u.id
                LEFT JOIN intervention_user AS iu ON i.id_intervention = iu.id_intervention
                LEFT JOIN users AS u_intervenant ON iu.id_intervenant = u_intervenant.id
                LEFT JOIN statut AS s ON i.id_statut = s.id_statut
                LEFT JOIN commentaire AS c ON i.id_intervention = c.id_intervention
                LEFT JOIN degre AS d ON i.id_degre = d.id_degre
                WHERE i.id_client = :id_client";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_client' => $this->session->get('id')]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

// Cette méthode prendra l'ID de l'intervention 
// Elle exécutera une requête SQL pour récupérer les commentaires correspondants à cet ID d'intervention.
// Elle renverra ensuite les commentaires récupérés.

    public function getCommentsForIntervention($interventionId)
{
    $sql = "SELECT infos FROM commentaire WHERE id_intervention = :interventionId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':interventionId' => $interventionId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function getInterventionInfo($interventionId)
    {
        $sql = "SELECT intervention.*, 
                       statut.statut AS nom_statut, 
                       degre.libelle AS nom_degre
                FROM intervention
                LEFT JOIN statut ON intervention.id_statut = statut.id_statut
                LEFT JOIN degre ON intervention.id_degre = degre.id_degre
                WHERE intervention.id_intervention = :interventionId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':interventionId' => $interventionId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Méthode pour ajouter un commentaire à une intervention
    public function ajouterCommentaire($interventionId, $commentaire)
    {
        $sql = "INSERT INTO commentaire (id_intervention, infos) VALUES (:interventionId, :commentaire)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':interventionId' => $interventionId, ':commentaire' => $commentaire]);
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
            $sql = "DELETE FROM intervention WHERE id_intervention = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id_intervention, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer l'erreur, par exemple en affichant un message ou en enregistrant dans un fichier de logs
            echo "Erreur lors de la suppression de l'intervention : " . $e->getMessage();
        }
    }
// fin de la méthode ; oui j'ai pas envie que ça se mélange mdr

// méthode pour update une intervention


public function getInterventionDetails($id_intervention)
{
    $sql = "SELECT * FROM intervention WHERE id_intervention = :id_intervention";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id_intervention', $id_intervention, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateIntervention($id_intervention, $description)
{
    $sql = "UPDATE intervention SET description = :description WHERE id_intervention = :id_intervention";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id_intervention', $id_intervention, PDO::PARAM_INT);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
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