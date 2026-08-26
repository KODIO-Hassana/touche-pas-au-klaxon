<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Trajets - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- HEADER ADMIN -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4"> 
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="/touche-pas-au-klaxon/admin/dashboard">⚙️ Touche pas au Klaxon (Admin)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminMenu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/dashboard">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/utilisateurs">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/agences">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/touche-pas-au-klaxon/admin/trajets">Trajets</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/touche-pas-au-klaxon/deconnexion" class="btn btn-danger btn-sm">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <!-- Zone des Messages Flash -->
        <?php if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">Gestion des Trajets</h1>
            
            <!-- Barre de recherche -->
            <form action="/touche-pas-au-klaxon/admin/trajets" method="GET" class="d-flex mx-auto my-2 my-md-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Chauffeur, ville..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <?php if(isset($_GET['sort'])): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Chercher</button>
                <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="/touche-pas-au-klaxon/admin/trajets" class="btn btn-outline-danger ms-2" title="Annuler">X</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th><a href="?sort=chauffeur" class="text-white text-decoration-none">Chauffeur ↕</a></th>
                                <th><a href="?sort=depart" class="text-white text-decoration-none">Départ ↕</a></th>
                                <th><a href="?sort=arrivee" class="text-white text-decoration-none">Arrivée ↕</a></th>
                                <th><a href="?sort=date" class="text-white text-decoration-none">Date & Heure ↕</a></th>
                                <th><a href="?sort=places" class="text-white text-decoration-none">Places dispo. ↕</a></th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($trajets)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Aucun trajet n'a été publié pour le moment.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($trajets as $trajet): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($trajet['chauffeur_prenom'] . ' ' . $trajet['chauffeur_nom']) ?></td>
                                        <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                                        <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($trajet['date_heure_depart'])) ?> à 
                                            <?= date('H:i', strtotime($trajet['date_heure_depart'])) ?>
                                        </td>
                                        <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
                                        <td class="text-end">
                                            <!-- Bouton Supprimer pour l'admin -->
                                            <form action="/touche-pas-au-klaxon/admin/trajets/supprimer" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce trajet ?');">
                                                <input type="hidden" name="id_trajet" value="<?= htmlspecialchars($trajet['id_trajet'] ?? $trajet['id']) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Bootstrap pour fermer les alertes -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>