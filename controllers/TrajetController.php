<?php

class TrajetController {

    // 1. Afficher le formulaire d'ajout
    public function afficherFormulaireAjout() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        require_once __DIR__ . '/../models/Agence.php';
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();

        require_once __DIR__ . '/../views/trajet_ajouter.php';
    }

    // 2. Traiter le formulaire d'ajout avec contrôles stricts
    public function traiterAjout() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_utilisateur = $_SESSION['utilisateur_id'];
            
            // Le trim() enlève les espaces invisibles qui faussent la comparaison
            $id_agence_depart = trim($_POST['id_agence_depart']);
            $id_agence_arrivee = trim($_POST['id_agence_arrivee']);
            $date_heure_depart = $_POST['date_heure_depart'];
            $date_heure_arrivee = $_POST['date_heure_arrivee'];
            $places_total = (int) $_POST['places_total'];

            $erreur = null;

            // Contrôles de cohérence
            if ($id_agence_depart === $id_agence_arrivee) {
                $erreur = "🚨 L'agence de départ et l'agence d'arrivée doivent être différentes.";
            } elseif (strtotime($date_heure_arrivee) <= strtotime($date_heure_depart)) {
                $erreur = "🚨 La date et l'heure d'arrivée doivent être postérieures au départ.";
            }

            // Si erreur, on bloque et on réaffiche
            if ($erreur !== null) {
                require_once __DIR__ . '/../models/Agence.php';
                $agenceModel = new Agence();
                $agences = $agenceModel->getAllAgences();
                require_once __DIR__ . '/../views/trajet_ajouter.php';
                return; 
            }

            // Sinon, on sauvegarde en base
            require_once __DIR__ . '/../models/Trajet.php';
            $trajetModel = new Trajet();
            
            if ($trajetModel->creerTrajet($id_utilisateur, $id_agence_depart, $id_agence_arrivee, $date_heure_depart, $date_heure_arrivee, $places_total)) {
                $_SESSION['flash_message'] = "Votre trajet a été publié avec succès !";
                header("Location: /touche-pas-au-klaxon/");
                exit();
            } else {
                $erreur = "🚨 Une erreur est survenue lors de l'enregistrement.";
                require_once __DIR__ . '/../models/Agence.php';
                $agenceModel = new Agence();
                $agences = $agenceModel->getAllAgences();
                require_once __DIR__ . '/../views/trajet_ajouter.php';
            }
        }
    }

    // 3. Supprimer un trajet
    public function supprimer() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_trajet'])) {
            require_once __DIR__ . '/../models/Trajet.php';
            $trajetModel = new Trajet();
            
            // CORRECTION ICI : On envoie l'ID du trajet ET l'ID de l'utilisateur
            $trajetModel->supprimerTrajet($_POST['id_trajet'], $_SESSION['utilisateur_id']);
            
            $_SESSION['flash_message'] = "Votre trajet a été définitivement supprimé.";
            header("Location: /touche-pas-au-klaxon/");
            exit();
        }
    }
}
?>