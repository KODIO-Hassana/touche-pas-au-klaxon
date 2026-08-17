<?php
// 1. On charge automatiquement tous les outils installés par Composer
require_once __DIR__ . '/vendor/autoload.php';

// 2. On importe le routeur que tu as téléchargé
use Buki\Router\Router;

// 3. On initialise le routeur
$router = new Router([
    'base_folder' => '/touche-pas-au-klaxon'
]);

// 4. On crée notre toute première "route" (la page d'accueil)
$router->get('/', function() {
    echo "<h1>Bienvenue sur l'application Touche pas au Klaxon !</h1>";
});

// 5. On demande au routeur de s'exécuter
$router->run();