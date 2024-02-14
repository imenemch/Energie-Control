<?php

namespace App;

use App\Session;

class Page
{
    private \Twig\Environment $twig;// Instance de la classe Twig pour la gestion des templates
    private $pdo;// Instance de la classe PDO pour la connexion à la base de données
    public $session;

    function __construct()
    {
        $this->session = new Session();

        try {
             // Connexion à la base de données MySQL
            $this->pdo = new \PDO('mysql:host=mysql;dbname=b2-paris', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());// Affichage du message d'erreur en cas d'échec de connexion
            die();// Arrêt du script en cas d'échec de connexion
        }

        // Configuration de l'environnement Twig
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',// Cache des templates Twig compilés
            'debug' => true// Activation du mode débogage de Twig
        ]);
    }

    // Fonction d'insertion des utilisateur lors de la création de compte
    public function insertUsers(string $table_name, array $data) 
    {
        // Requête SQL d'insertion avec des paramètres nommés (:email, :password)
       $sql = "INSERT INTO " . $table_name. " (email, nom, prenom, adresse, tel, password) VALUES 
       (:email, :nom, :prenom, :adresse, :tel, :password)";
       $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
       $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    // Fonction d'insertion des cliens lors de la création d'une intervention
    public function insertClient(string $table_name, array $data)
    {
        // Requête SQL d'insertion 
       $sql = "INSERT INTO " . $table_name . " (email, nom, prenom, adresse, tel) VALUES 
       (:email, :nom, :prenom, :adresse, :tel)";
       $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
       $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    // Fonction d'insertion des interventions
    public function insertIntervention(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (id_client, id_standariste, id_statut, id_degre, id_commentaire,
        description, type, date) VALUES(:id_client, :id_standardiste, :id_statut, :id_degre, :id_commentaire,
        :description, :type, :date)"; 
        $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
        $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    // Fonction d'insertion des commentaires 
    public function insertCommentaire(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (infos) VALUES (:infos)";
        $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
        $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    // Fonction d'insertion du degré d'urgence de l'intervention
    public function insertDegre(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (libelle) VALUES (:libelle)";
        $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
        $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    // Fonction d'insertion du statut de l'intervention
    public function insertStatut(string $table_name, array $data)
    {
        $sql = "INSERT INTO " . $table_name . " (statut) VALUES (:statut)";
        $stmt = $this->pdo->prepare($sql);// Préparation de la requête SQL
        $stmt->execute($data);// Exécution de la requête SQL avec les données fournies
    }

    //  Fonction pour récupérer un user à partir de l'email
    public function getUserByEmail(array $data)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Fonction qui récupère les user qui ont pour rôle intervenant
    public function getIntervenant()
    {
        $sql = "SELECT * FROM users WHERE role = 'intervenant'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    

    public function render(string $name, array $data) :string
    {
        return $this->twig->render($name, $data);// Rendu du template Twig avec les données fournies
    }
}