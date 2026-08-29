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

    // Afficher la page de gestion des agences (avec tri et recherche)
    public function manageAgences() {
        $this->verifierAdmin(); 
        
        require_once __DIR__ . '/../models/Agence.php';
        $agenceModel = new Agence();
        
        // On récupère le tri et la recherche dans l'URL
        $tri_demande = isset($_GET['sort']) ? $_GET['sort'] : 'nom';
        $recherche_demande = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $agences = $agenceModel->getAllAgences($tri_demande, $recherche_demande);
        
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

    public function manageUsers() {
        $this->verifierAdmin(); 
        
        require_once __DIR__ . '/../models/Utilisateur.php';
        $userModel = new Utilisateur();
        
        // On récupère le tri et la recherche depuis l'URL
        $tri_demande = isset($_GET['sort']) ? $_GET['sort'] : 'nom';
        $recherche_demande = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // On envoie les deux infos au Modèle
        $utilisateurs = $userModel->getAllUtilisateurs($tri_demande, $recherche_demande);
        
        require_once __DIR__ . '/../views/admin_utilisateurs.php';
    }

    // --- PARTIE GESTION DES TRAJETS (ADMIN) ---
    
    // 1. Afficher tous les trajets (avec tri et recherche)
    public function manageTrajets() {
        $this->verifierAdmin();
        
        require_once __DIR__ . '/../models/Trajet.php';
        $trajetModel = new Trajet();
        
        // Récupération des paramètres dans l'URL (ou valeurs par défaut)
        $tri_demande = isset($_GET['sort']) ? $_GET['sort'] : 'date';
        $recherche_demande = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $trajets = $trajetModel->getAllTrajetsAdmin($tri_demande, $recherche_demande);
        
        require_once __DIR__ . '/../views/admin_trajets.php';
    }

    // 2. Supprimer un trajet (Pouvoir de l'admin)
    public function deleteTrajet() {
        $this->verifierAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_trajet'])) {
            require_once __DIR__ . '/../models/Trajet.php';
            $trajetModel = new Trajet();
            
            // On utilise la fonction de suppression que tu avais déjà créée pour l'employé
            if ($trajetModel->supprimerTrajetAdmin($_POST['id_trajet'])) {
                $_SESSION['flash_message'] = "Le trajet a été supprimé par l'administrateur.";
            } else {
                $_SESSION['flash_message'] = "Erreur lors de la suppression du trajet.";
            }
        }
        
        header("Location: /touche-pas-au-klaxon/admin/trajets");
        exit();
    }

}
?>