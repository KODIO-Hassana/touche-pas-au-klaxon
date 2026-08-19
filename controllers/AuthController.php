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
                
                // C'est un succès ! On stocke son prénom dans la session
                $_SESSION['utilisateur_prenom'] = $user['prenom'];
                $_SESSION['utilisateur_id'] = $user['id_utilisateur'];

                // On le renvoie vers la page d'accueil
                header("Location: /touche-pas-au-klaxon/");
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

    // Afficher le formulaire d'inscription
    public function register() {
        require_once __DIR__ . '/../views/inscription.php';
    }

    // Traiter les données de l'inscription
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            $userModel = new Utilisateur();
            
            // On enregistre l'utilisateur
            $succes = $userModel->createUser($nom, $prenom, $email, $password);

            if ($succes) {
                // Si ça marche, on le renvoie vers la page de connexion pour qu'il s'identifie
                header("Location: /touche-pas-au-klaxon/connexion");
                exit();
            } else {
                $erreur = "Une erreur est survenue lors de l'inscription.";
                require_once __DIR__ . '/../views/inscription.php';
            }
        }
    }
}
?>