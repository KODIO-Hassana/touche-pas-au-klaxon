<?php
require_once __DIR__ . '/../models/Agence.php';
require_once __DIR__ . '/../models/Trajet.php'; // On importe le nouveau modèle

class HomeController {
    public function index() {
        // On inclut le modèle Trajet
        require_once __DIR__ . '/../models/Trajet.php';
        $trajetModel = new Trajet();
        
        // On récupère les trajets filtrés
        $trajets = $trajetModel->getTrajetsDisponibles();
        
        // On charge la vue de l'accueil
        require_once __DIR__ . '/../views/accueil.php'; 
    }
}
?>