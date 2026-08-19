<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Touche pas au Klaxon</title>
    <!-- LIEN VERS BOOTSTRAP (La magie visuelle opère ici) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Barre de navigation moderne -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/touche-pas-au-klaxon/">🚗 Touche pas au Klaxon</a>
            <div class="d-flex text-white align-items-center">
                <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
                    <span class="me-3">Bonjour, <strong><?= htmlspecialchars($_SESSION['utilisateur_prenom']) ?></strong></span>
                    <a href="/touche-pas-au-klaxon/deconnexion" class="btn btn-danger btn-sm">Se déconnecter</a>
                <?php else: ?>
                    <a href="/touche-pas-au-klaxon/connexion" class="btn btn-light btn-sm">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Conteneur principal qui centre le contenu -->
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Tableau de bord des trajets</h1>
            <a href="/touche-pas-au-klaxon/trajet/ajouter" class="btn btn-success">+ Proposer un trajet</a>
        </div>

        <div class="row">
            <!-- Colonne pour les trajets (prend plus de place) -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Trajets disponibles</h2>
                    </div>
                    <div class="card-body">
                        <?php if (empty($trajets)): ?>
                            <p class="text-muted">Aucun trajet proposé pour le moment.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach($trajets as $trajet): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">De <?= htmlspecialchars($trajet['ville_depart']) ?> à <?= htmlspecialchars($trajet['ville_arrivee']) ?></h6>
                                            <small class="text-muted">Départ le : <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($trajet['date_heure_depart']))) ?></small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            <?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_total']) ?> places
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Colonne pour les agences (plus petite sur le côté) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Nos agences</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach($agences as $agence): ?>
                                <li class="list-group-item"><?= htmlspecialchars($agence['nom']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>