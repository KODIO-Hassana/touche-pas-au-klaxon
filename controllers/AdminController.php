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

    // Afficher le formulaire d'ajout d'une agence
    public function createAgence() {
        $this->verifierAdmin(); // Toujours bloquer les intrus !
        require_once __DIR__ . '/../views/admin_agence_ajouter.php';
    }

    // Traiter l'enregistrement de la nouvelle agence
    public function storeAgence() {
        $this->verifierAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom_agence'])) {
            require_once __DIR__ . '/../models/Agence.php';
            $agenceModel = new Agence();
            
            if ($agenceModel->ajouterAgence($_POST['nom_agence'])) {
                $_SESSION['flash_message'] = "L'agence a été ajoutée avec succès !";
            } else {
                $_SESSION['flash_message'] = "Erreur lors de l'ajout de l'agence.";
            }
        }
        
        // On redirige vers la liste des agences
        header("Location: /touche-pas-au-klaxon/admin/agences");
        exit();
    }

    // --- PARTIE MODIFICATION ---
    public function editAgence() {
        $this->verifierAdmin();
        if (isset($_GET['id'])) {
            require_once __DIR__ . '/../models/Agence.php';
            $agenceModel = new Agence();
            $agence = $agenceModel->getAgenceById($_GET['id']);
            
            if ($agence) {
                require_once __DIR__ . '/../views/admin_agence_modifier.php';
            } else {
                header("Location: /touche-pas-au-klaxon/admin/agences");
                exit();
            }
        }
    }

    public function updateAgence() {
        $this->verifierAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_agence'], $_POST['nom_agence'])) {
            require_once __DIR__ . '/../models/Agence.php';
            $agenceModel = new Agence();
            
            if ($agenceModel->modifierAgence($_POST['id_agence'], $_POST['nom_agence'])) {
                $_SESSION['flash_message'] = "L'agence a été modifiée avec succès !";
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la modification.";
            }
        }
        header("Location: /touche-pas-au-klaxon/admin/agences");
        exit();
    }

    // --- PARTIE SUPPRESSION ---
    public function deleteAgence() {
        $this->verifierAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_agence'])) {
            require_once __DIR__ . '/../models/Agence.php';
            $agenceModel = new Agence();
            
            // Si des trajets utilisent cette ville, la suppression sera bloquée par la BDD par sécurité
            if ($agenceModel->supprimerAgence($_POST['id_agence'])) {
                $_SESSION['flash_message'] = "L'agence a été supprimée définitivement.";
            } else {
                $_SESSION['flash_message'] = "Erreur : Impossible de supprimer cette agence (des trajets y sont probablement rattachés).";
            }
        }
        header("Location: /touche-pas-au-klaxon/admin/agences");
        exit();
    }

}
?>