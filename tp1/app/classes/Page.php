<?php

namespace App;

use App\Session;

class Page
{
    private \Twig\Environment $twig;
    private $pdo;
    public $session;

    function __construct()
    {
        $this->session = new Session();

        try {
            $this->pdo = new \PDO('mysql:host=mysql;dbname=b2-paris', "root", "");
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

    public function executeQuery(string $query) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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


    public function getAllClient()
    {
        $sql = "SELECT * FROM users WHERE role = 'client'";
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