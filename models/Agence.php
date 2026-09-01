<?php
require_once 'Database.php';

class Agence {
    private $conn;

    public function __construct() {
        // On se connecte à la base de données dès qu'on appelle cette classe
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Récupère toutes les agences de la base de données.
     *
     * @param string $tri Le nom de la colonne pour ordonner les résultats (par défaut 'nom').
     * @param string $recherche Le terme recherché pour filtrer les agences (par défaut vide).
     * @return array La liste des agences sous forme de tableau associatif.
     */

    public function getAllAgences($tri = 'nom', $recherche = '') {
        // Liste blanche pour sécuriser le tri
        $colonnes_autorisees = ['id_agence', 'nom'];
        if (!in_array($tri, $colonnes_autorisees)) {
            $tri = 'nom'; // Tri alphabétique par défaut !
        }

        if (!empty($recherche)) {
            $requete = "SELECT * FROM agence WHERE nom LIKE :recherche ORDER BY $tri ASC";
            $stmt = $this->conn->prepare($requete);
            $terme = '%' . $recherche . '%';
            $stmt->bindParam(':recherche', $terme);
        } else {
            $requete = "SELECT * FROM agence ORDER BY $tri ASC";
            $stmt = $this->conn->prepare($requete);
        }
        
        $stmt->execute();
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