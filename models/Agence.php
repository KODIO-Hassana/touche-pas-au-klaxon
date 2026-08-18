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
}
?>