<?php
require_once __DIR__ . '/../models/Agence.php';
require_once __DIR__ . '/../models/Trajet.php'; // On importe le nouveau modèle

class HomeController {
    public function index() {
        // Récupération des agences
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();

        // Récupération des trajets
        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAllTrajets();

        // On charge l'affichage
        require_once __DIR__ . '/../views/accueil.php';
    }
}
?>