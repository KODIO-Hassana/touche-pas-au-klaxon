<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Touche pas au Klaxon</title>
</head>
<body>
    <!-- En-tête de connexion -->
    <div style="background-color: #f0f0f0; padding: 10px; text-align: right;">
        <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
            <p>Bonjour, <strong><?= htmlspecialchars($_SESSION['utilisateur_prenom']) ?></strong> ! 
            <a href="/touche-pas-au-klaxon/deconnexion" style="margin-left: 15px; color: red;">Se déconnecter</a></p>
        <?php else: ?>
            <p><a href="/touche-pas-au-klaxon/connexion">Se connecter</a></p>
        <?php endif; ?>
    </div>

    <h1>Bienvenue sur l'application Touche pas au Klaxon !</h1>
    <a href="/touche-pas-au-klaxon/trajet/ajouter"><button>Proposer un trajet</button></a>

    <h2>Trajets disponibles :</h2>
    <ul>
        <?php if (empty($trajets)): ?>
            <li>Aucun trajet proposé pour le moment.</li>
        <?php else: ?>
            <?php foreach($trajets as $trajet): ?>
                <li style="margin-bottom: 10px;">
                    <strong>Départ le :</strong> <?= htmlspecialchars($trajet['date_heure_depart']) ?> <br>
                    <strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_total']) ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <hr>
    
    <h2>Liste de nos agences :</h2>
    <ul>
        <?php foreach($agences as $agence): ?>
            <li><?= htmlspecialchars($agence['nom']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>