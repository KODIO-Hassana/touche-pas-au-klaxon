<?php
require_once 'Database.php';

class Agence {
    private $conn;

    public function __construct() {
        // On se connecte à la base de données dès qu'on appelle cette classe
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Fonction pour récupérer toutes les agences
    public function getAllAgences() {
        $requete = "SELECT * FROM agence";
        $stmt = $this->conn->prepare($requete);
        $stmt->execute();
        
        // On renvoie les résultats sous forme de tableau
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction pour ajouter une nouvelle agence
    public function ajouterAgence($nom) {
        $requete = "INSERT INTO agence (nom) VALUES (:nom)";
        $stmt = $this->conn->prepare($requete);
        
        $stmt->bindParam(':nom', $nom);
        
        return $stmt->execute();
    }

    // 1. Récupérer les infos d'une seule agence
    public function getAgenceById($id_agence) {
        $requete = "SELECT * FROM agence WHERE id_agence = :id_agence";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':id_agence', $id_agence);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Modifier (mettre à jour) l'agence
    public function modifierAgence($id_agence, $nom) {
        $requete = "UPDATE agence SET nom = :nom WHERE id_agence = :id_agence";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':id_agence', $id_agence);
        
        return $stmt->execute();
    }

    // 3. Supprimer l'agence
    public function supprimerAgence($id_agence) {
        $requete = "DELETE FROM agence WHERE id_agence = :id_agence";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':id_agence', $id_agence);
        
        return $stmt->execute();
    }

}
?>