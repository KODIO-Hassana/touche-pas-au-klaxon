<?php
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Agence.php'; // Nécessaire pour afficher les villes dans le menu déroulant

class TrajetController {
    
    // 1. Afficher la page du formulaire
    public function create() {
        // Sécurité : on bloque l'accès si l'employé n'est pas connecté
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        // On récupère les agences pour remplir les menus déroulants du formulaire
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();

        require_once __DIR__ . '/../views/ajouter_trajet.php';
    }

    // 2. Traiter le formulaire au moment du clic sur le bouton "Publier"
    public function store() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère tout ce que l'utilisateur a tapé
            $agence_depart = $_POST['id_agence_depart'];
            $agence_arrivee = $_POST['id_agence_arrivee'];
            $depart = $_POST['date_heure_depart'];
            $arrivee = $_POST['date_heure_arrivee'];
            $places = $_POST['places_total'];
            
            // On récupère l'ID du créateur directement depuis sa session !
            $id_utilisateur = $_SESSION['utilisateur_id']; 

            // On demande au modèle d'insérer tout ça
            $trajetModel = new Trajet();
            $succes = $trajetModel->ajouterTrajet($depart, $arrivee, $places, $id_utilisateur, $agence_depart, $agence_arrivee);

            if ($succes) {
                // Si ça marche, on le renvoie à l'accueil
                header("Location: /touche-pas-au-klaxon/");
                exit();
            } else {
                echo "Une erreur est survenue lors de l'enregistrement.";
            }
        }
    }

    // 3. Traiter la réservation d'un trajet
    public function reserver() {
        // Sécurité : il faut être connecté pour réserver
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        // On vérifie qu'on a bien reçu l'ID du trajet à réserver
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_trajet'])) {
            $trajetModel = new Trajet();
            $trajetModel->reserverPlace($_POST['id_trajet']);
        }

        // On redirige vers l'accueil pour voir la mise à jour des places
        header("Location: /touche-pas-au-klaxon/");
        exit();
    }
}
?>