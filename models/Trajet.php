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
    // public function getAllTrajets() {
    //     $requete = "SELECT * FROM trajet ORDER BY date_heure_depart ASC";
    //     $stmt = $this->conn->prepare($requete);
    //     $stmt->execute();
        
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getAllTrajets() {
        // On sélectionne tout le trajet, les noms des agences ET les infos du chauffeur
        $requete = "SELECT trajet.*, 
                           dep.nom AS ville_depart, 
                           arr.nom AS ville_arrivee,
                           u.nom AS chauffeur_nom,
                           u.prenom AS chauffeur_prenom,
                           u.telephone AS chauffeur_telephone,
                           u.email AS chauffeur_email
                    FROM trajet 
                    INNER JOIN agence AS dep ON trajet.id_agence_depart = dep.id_agence 
                    INNER JOIN agence AS arr ON trajet.id_agence_arrivee = arr.id_agence 
                    INNER JOIN utilisateur AS u ON trajet.id_utilisateur = u.id_utilisateur
                    ORDER BY date_heure_depart ASC";
        
        $stmt = $this->conn->prepare($requete);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction pour réserver une place (soustrait 1 aux places disponibles)
    public function reserverPlace($id_trajet) {
        // L'instruction UPDATE modifie une ligne existante
        $requete = "UPDATE trajet SET places_disponibles = places_disponibles - 1 WHERE id_trajet = :id AND places_disponibles > 0";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':id', $id_trajet);
        
        return $stmt->execute();
    }

    // Fonction pour supprimer un trajet (Sécurisée : on vérifie que c'est bien l'auteur qui supprime)
    public function supprimerTrajet($id_trajet, $id_utilisateur) {
        $requete = "DELETE FROM trajet WHERE id_trajet = :id_trajet AND id_utilisateur = :id_utilisateur";
        $stmt = $this->conn->prepare($requete);
        
        $stmt->bindParam(':id_trajet', $id_trajet);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        
        return $stmt->execute();
    }
}
?>