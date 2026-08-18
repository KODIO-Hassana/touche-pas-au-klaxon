<?php
require_once 'Database.php';

class Trajet {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Fonction pour insérer un nouveau trajet
    public function ajouterTrajet($depart, $arrivee, $places, $id_utilisateur, $agence_depart, $agence_arrivee) {
        // La requête SQL avec les vrais noms de tes colonnes
        $requete = "INSERT INTO trajet (date_heure_depart, date_heure_arrivee, places_total, places_disponibles, id_utilisateur, id_agence_depart, id_agence_arrivee) 
                    VALUES (:depart, :arrivee, :places, :dispo, :user, :agence_dep, :agence_arr)";
        
        $stmt = $this->conn->prepare($requete);
        
        // On relie les variables aux paramètres de la requête
        $stmt->bindParam(':depart', $depart);
        $stmt->bindParam(':arrivee', $arrivee);
        $stmt->bindParam(':places', $places);
        
        // Astuce logique : à la création, le nombre de places disponibles est égal au total des places !
        $stmt->bindParam(':dispo', $places); 
        
        $stmt->bindParam(':user', $id_utilisateur);
        $stmt->bindParam(':agence_dep', $agence_depart);
        $stmt->bindParam(':agence_arr', $agence_arrivee);
        
        // On exécute et on renvoie vrai (succès) ou faux (échec)
        return $stmt->execute();
    }

    // Fonction pour récupérer tous les trajets disponibles
    public function getAllTrajets() {
        $requete = "SELECT * FROM trajet ORDER BY date_heure_depart ASC";
        $stmt = $this->conn->prepare($requete);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>