<?php
require_once __DIR__ . '/../models/Agence.php';

class HomeController {
    public function index() {
        // 1. On demande au Modèle de récupérer les agences
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();

        // 2. On charge la Vue (l'affichage) en lui transmettant la variable $agences
        require_once __DIR__ . '/../views/accueil.php';
    }
}
?>