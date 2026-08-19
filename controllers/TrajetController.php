<?php
require_once __DIR__ . '/../models/Trajet.php';
require_once __DIR__ . '/../models/Agence.php';

class TrajetController {
    
    public function create() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();
        require_once __DIR__ . '/../views/ajouter_trajet.php';
    }

    public function store() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $agence_depart = $_POST['id_agence_depart'];
            $agence_arrivee = $_POST['id_agence_arrivee'];
            $depart = $_POST['date_heure_depart'];
            $arrivee = $_POST['date_heure_arrivee'];
            $places = $_POST['places_total'];
            $id_utilisateur = $_SESSION['utilisateur_id']; 

            $trajetModel = new Trajet();
            $succes = $trajetModel->ajouterTrajet($depart, $arrivee, $places, $id_utilisateur, $agence_depart, $agence_arrivee);

            if ($succes) {
                // ENREGISTREMENT DU MESSAGE FLASH
                $_SESSION['flash_message'] = "Votre trajet a été publié avec succès !";
                header("Location: /touche-pas-au-klaxon/");
                exit();
            } else {
                echo "Une erreur est survenue lors de l'enregistrement.";
            }
        }
    }

    public function reserver() {
        if (!isset($_SESSION['utilisateur_id'])) {
            header("Location: /touche-pas-au-klaxon/connexion");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_trajet'])) {
            $trajetModel = new Trajet();
            $trajetModel->reserverPlace($_POST['id_trajet']);
            
            // ENREGISTREMENT DU MESSAGE FLASH
            $_SESSION['flash_message'] = "Votre place a bien été réservée !";
        }

        header("Location: /touche-pas-au-klaxon/");
        exit();
    }
}
?>