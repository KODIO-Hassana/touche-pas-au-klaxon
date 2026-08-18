<?php

//0. On active les sessions
session_start();

// 1. On charge automatiquement tous les outils installés par Composer
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';

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

// 5. On demande au routeur de s'exécuter
$router->run();