<?php
require_once 'Database.php';

class Utilisateur {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Fonction pour trouver un utilisateur grâce à son email
    public function getUserByEmail($email) {
        $requete = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction pour créer un nouvel utilisateur
    public function createUser($nom, $prenom, $email, $mot_de_passe) {
        // Assure-toi que les noms des colonnes (nom, prenom, email, mot_de_passe) correspondent bien à ta table phpMyAdmin
        $requete = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) 
                    VALUES (:nom, :prenom, :email, :mdp)";
        
        $stmt = $this->conn->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mdp', $mot_de_passe);
        
        return $stmt->execute();
    }
}
?>