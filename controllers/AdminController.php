<?php

class AdminController {
    
    // Fonction de sécurité pour vérifier si l'utilisateur est bien un admin
    private function verifierAdmin() {
        if (!isset($_SESSION['utilisateur_id']) || $_SESSION['utilisateur_role'] !== 'admin') {
            // Si ce n'est pas un admin, on le renvoie à l'accueil avec un message
            $_SESSION['flash_message'] = "Accès refusé : vous n'êtes pas administrateur.";
            header("Location: /touche-pas-au-klaxon/");
            exit();
        }
    }

    // Afficher le tableau de bord
    public function dashboard() {
        $this->verifierAdmin(); // On bloque les intrus
        
        // (Bientôt, on ira chercher ici la liste des utilisateurs, agences, etc.)
        
        require_once __DIR__ . '/../views/admin_dashboard.php';
    }

    // Afficher la page de gestion des agences
    public function manageAgences() {
        $this->verifierAdmin(); // On bloque les intrus
        
        // On récupère la liste complète des agences depuis la base de données
        require_once __DIR__ . '/../models/Agence.php';
        $agenceModel = new Agence();
        $agences = $agenceModel->getAllAgences();
        
        require_once __DIR__ . '/../views/admin_agences.php';
    }
    
}
?>