<?php

//0. On active les sessions
session_start();

// 1. On charge automatiquement tous les outils installés par Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/TrajetController.php';

require_once 'controllers/AdminController.php'; 

// 2. On importe le routeur que tu as téléchargé
use Buki\Router\Router;

// 3. On initialise le routeur
$router = new Router([
    'base_folder' => '/touche-pas-au-klaxon'
]);

// 4. On modifie notre route pour qu'elle utilise le Contrôleur
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

// Route pour AFFICHER le formulaire de connexion
$router->get('/connexion', function() {
    $controller = new AuthController();
    $controller->login();
});

// Route pour TRAITER le formulaire quand on clique sur "Se connecter"
$router->post('/connexion', function() {
    $controller = new AuthController();
    $controller->authenticate();
});

// Route pour se déconnecter
$router->get('/deconnexion', function() {
    $controller = new AuthController();
    $controller->logout();
});

// Afficher le formulaire pour proposer un trajet (GET)
$router->get('/trajet/ajouter', function() {
    require_once __DIR__ . '/controllers/TrajetController.php';
    $controller = new TrajetController();
    $controller->afficherFormulaireAjout(); // Le bon nom de la fonction !
});

// Traiter l'envoi du formulaire (POST)
$router->post('/trajet/ajouter', function() {
    require_once __DIR__ . '/controllers/TrajetController.php';
    $controller = new TrajetController();
    $controller->traiterAjout(); // Le bon nom de la fonction de traitement !
});

// Route pour RESERVER une place
$router->post('/trajet/reserver', function() {
    $controller = new TrajetController();
    $controller->reserver();
});

// Route pour SUPPRIMER un trajet
$router->post('/trajet/supprimer', function() {
    $controller = new TrajetController();
    $controller->supprimer();
});

// Routes pour MODIFIER un trajet
$router->get('/trajet/modifier', function() {
    $controller = new TrajetController();
    $controller->edit();
});

$router->post('/trajet/modifier', function() {
    $controller = new TrajetController();
    $controller->update();
});


// Route pour le Tableau de bord Admin
$router->get('/admin/dashboard', function() {
    $controller = new AdminController();
    $controller->dashboard();
});

// Route pour gérer les agences (Admin)
$router->get('/admin/agences', function() {
    $controller = new AdminController();
    $controller->manageAgences();
});

// Routes pour AJOUTER une agence (Admin)
$router->get('/admin/agences/ajouter', function() {
    $controller = new AdminController();
    $controller->createAgence();
});

$router->post('/admin/agences/ajouter', function() {
    $controller = new AdminController();
    $controller->storeAgence();
});

// Routes pour MODIFIER une agence
$router->get('/admin/agences/modifier', function() {
    $controller = new AdminController();
    $controller->editAgence();
});
$router->post('/admin/agences/modifier', function() {
    $controller = new AdminController();
    $controller->updateAgence();
});

// Route pour SUPPRIMER une agence
$router->post('/admin/agences/supprimer', function() {
    $controller = new AdminController();
    $controller->deleteAgence();
});

// Route pour lister les utilisateurs (Admin)
$router->get('/admin/utilisateurs', function() {
    $controller = new AdminController();
    $controller->manageUsers();
});

// Routes pour gérer les TRAJETS (Admin)
$router->get('/admin/trajets', function() {
    $controller = new AdminController();
    $controller->manageTrajets();
});

$router->post('/admin/trajets/supprimer', function() {
    $controller = new AdminController();
    $controller->deleteTrajet();
});

$router->run();