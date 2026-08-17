<?php

class Database {
    // Paramètres de connexion par défaut pour XAMPP
    private $host = "localhost";
    private $db_name = "touche_pas_au_klaxon";
    private $username = "root";
    private $password = ""; // Sur XAMPP, il n'y a pas de mot de passe par défaut
    public $conn;

    // Méthode pour établir la connexion
    public function getConnection() {
        $this->conn = null;

        try {
            // On tente de se connecter avec PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", 
                $this->username, 
                $this->password
            );
            // On demande à PDO d'afficher les erreurs si la requête échoue
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Si la connexion échoue, on affiche le message d'erreur
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>