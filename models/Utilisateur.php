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

    // Fonction avec Tri ET Recherche combinés
    public function getAllUtilisateurs($tri = 'nom', $recherche = '') {
        $colonnes_autorisees = ['id_utilisateur', 'nom', 'prenom', 'email', 'role'];
        if (!in_array($tri, $colonnes_autorisees)) {
            $tri = 'nom';
        }

        // Si l'administrateur a tapé une recherche
        if (!empty($recherche)) {
            // On cherche dans le nom, le prénom OU l'email
            $requete = "SELECT * FROM utilisateur 
                        WHERE nom LIKE :recherche OR prenom LIKE :recherche OR email LIKE :recherche 
                        ORDER BY $tri ASC";
            $stmt = $this->conn->prepare($requete);
            
            // Les % permettent de chercher le mot même s'il est au milieu d'une phrase
            $terme = '%' . $recherche . '%';
            $stmt->bindParam(':recherche', $terme);
        } else {
            // S'il n'y a pas de recherche, on liste tout normalement
            $requete = "SELECT * FROM utilisateur ORDER BY $tri ASC";
            $stmt = $this->conn->prepare($requete);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>