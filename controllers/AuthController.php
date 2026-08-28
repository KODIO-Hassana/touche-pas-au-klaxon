<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class AuthController {
    
    // Fonction pour afficher la page
    public function login() {
        require_once __DIR__ . '/../views/connexion.php';
    }
// Fonction pour vérifier les identifiants
    public function authenticate() {
        if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            $userModel = new Utilisateur();
            $user = $userModel->getUserByEmail($email);

            // On vérifie si l'utilisateur existe ET si le mot de passe correspond
            if ($user && $user['mot_de_passe'] === $password) {
                
                // C'est un succès ! On stocke ses informations dans la session
                $_SESSION['utilisateur_prenom'] = $user['prenom'];
                $_SESSION['utilisateur_id'] = $user['id_utilisateur'];
                $_SESSION['utilisateur_role'] = $user['role'];

                // CORRECTION ICI : On utilise $user et non $utilisateur
                $_SESSION['utilisateur_nom'] = $user['nom'];
                $_SESSION['utilisateur_email'] = $user['email'];
    
                // Aiguillage automatique selon le rôle
                if ($_SESSION['utilisateur_role'] === 'admin') {
                    header("Location: /touche-pas-au-klaxon/admin/dashboard");
                } else {
                    header("Location: /touche-pas-au-klaxon/");
                }
                exit();
            } else {
                // C'est un échec, on renvoie la vue avec un message d'erreur
                $erreur = "Identifiants incorrects.";
                require_once __DIR__ . '/../views/connexion.php';
            }
        }
    }

    // Fonction pour se déconnecter
    public function logout() {
        session_destroy();
        header("Location: /touche-pas-au-klaxon/");
        exit();
    }

    
}
?>