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

   // Fonction exclusive Admin : Récupérer TOUS les trajets (avec Tri et Recherche)
    public function getAllTrajetsAdmin($tri = 'date', $recherche = '') {
        // 1. Gestion du tri sécurisé
        $order_by = 't.date_heure_depart DESC'; // Tri par défaut (les plus récents en premier)
        
        if ($tri === 'chauffeur') $order_by = 'u.nom ASC';
        if ($tri === 'depart') $order_by = 'ad.nom ASC';
        if ($tri === 'arrivee') $order_by = 'aa.nom ASC';
        if ($tri === 'places') $order_by = 't.places_disponibles ASC';

        // 2. Construction de la requête de base
        $requete = "SELECT t.*, 
                           u.nom AS chauffeur_nom, u.prenom AS chauffeur_prenom,
                           ad.nom AS ville_depart, 
                           aa.nom AS ville_arrivee
                    FROM trajet t
                    JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                    JOIN agence ad ON t.id_agence_depart = ad.id_agence
                    JOIN agence aa ON t.id_agence_arrivee = aa.id_agence";

        // 3. Ajout de la recherche si l'admin a tapé quelque chose
        if (!empty($recherche)) {
            // On cherche dans le nom/prénom du chauffeur, ou dans le nom des villes
            $requete .= " WHERE u.nom LIKE :recherche 
                             OR u.prenom LIKE :recherche 
                             OR ad.nom LIKE :recherche 
                             OR aa.nom LIKE :recherche";
        }
        
        // 4. On ajoute la condition de tri à la fin
        $requete .= " ORDER BY " . $order_by;
        
        $stmt = $this->conn->prepare($requete);
        
        // 5. On insère le mot recherché s'il y en a un
        if (!empty($recherche)) {
            $terme = '%' . $recherche . '%';
            $stmt->bindParam(':recherche', $terme);
        }
        
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

    // Fonction pour récupérer les détails d'un SEUL trajet (pour pré-remplir le formulaire)
    public function getTrajetById($id_trajet) {
        $requete = "SELECT * FROM trajet WHERE id_trajet = :id_trajet";
        $stmt = $this->conn->prepare($requete);
        $stmt->bindParam(':id_trajet', $id_trajet);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction pour mettre à jour (écraser) les données du trajet
    public function modifierTrajet($id_trajet, $id_utilisateur, $id_agence_depart, $id_agence_arrivee, $date_heure_depart, $date_heure_arrivee, $places_total) {
        // La requête UPDATE modifie une ligne existante. On vérifie l'id_utilisateur par sécurité !
        // AJOUT CRUCIAL : On met aussi à jour places_disponibles
        $requete = "UPDATE trajet 
                    SET id_agence_depart = :agence_depart, 
                        id_agence_arrivee = :agence_arrivee, 
                        date_heure_depart = :depart, 
                        date_heure_arrivee = :arrivee, 
                        places_total = :places, 
                        places_disponibles = :places 
                    WHERE id_trajet = :id_trajet AND id_utilisateur = :id_utilisateur";
        
        $stmt = $this->conn->prepare($requete);
        
        // On relie les paramètres avec la même logique que creerTrajet
        $stmt->bindParam(':id_trajet', $id_trajet);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':agence_depart', $id_agence_depart);
        $stmt->bindParam(':agence_arrivee', $id_agence_arrivee);
        $stmt->bindParam(':depart', $date_heure_depart);
        $stmt->bindParam(':arrivee', $date_heure_arrivee);
        $stmt->bindParam(':places', $places_total);
        
        return $stmt->execute();
    }

    // Fonction pour l'accueil : Trajets futurs avec places disponibles, triés par date croissante
    public function getTrajetsDisponibles() {
        try {
            $requete = "SELECT t.*, 
                               u.nom AS chauffeur_nom, u.prenom AS chauffeur_prenom, u.telephone, u.email,
                               ad.nom AS ville_depart, 
                               aa.nom AS ville_arrivee
                        FROM trajet t
                        JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                        JOIN agence ad ON t.id_agence_depart = ad.id_agence
                        JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                        WHERE t.places_disponibles > 0 
                        AND t.date_heure_depart >= NOW() 
                        ORDER BY t.date_heure_depart ASC"; 
                        
            $stmt = $this->conn->prepare($requete);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("🚨 Erreur SQL détectée : " . $e->getMessage());
        }
    }

    // Créer un nouveau trajet
    public function creerTrajet($id_utilisateur, $id_agence_depart, $id_agence_arrivee, $date_heure_depart, $date_heure_arrivee, $places_total) {
        try {
            // À la création, le nombre de places disponibles est égal au nombre de places total
            $requete = "INSERT INTO trajet (id_utilisateur, id_agence_depart, id_agence_arrivee, date_heure_depart, date_heure_arrivee, places_total, places_disponibles) 
                        VALUES (:id_utilisateur, :id_agence_depart, :id_agence_arrivee, :date_heure_depart, :date_heure_arrivee, :places_total, :places_disponibles)";
            
            $stmt = $this->conn->prepare($requete);
            
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_agence_depart', $id_agence_depart);
            $stmt->bindParam(':id_agence_arrivee', $id_agence_arrivee);
            $stmt->bindParam(':date_heure_depart', $date_heure_depart);
            $stmt->bindParam(':date_heure_arrivee', $date_heure_arrivee);
            $stmt->bindParam(':places_total', $places_total);
            $stmt->bindParam(':places_disponibles', $places_total); 
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die("🚨 Erreur SQL lors de la création : " . $e->getMessage());
        }
    }

 

}
?>