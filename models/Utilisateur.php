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
}
?>