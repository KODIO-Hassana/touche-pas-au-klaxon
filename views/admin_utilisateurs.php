<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs - Admin</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="/touche-pas-au-klaxon/assets/scss/custom.css" rel="stylesheet">
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
                        <a class="nav-link active" href="/touche-pas-au-klaxon/admin/utilisateurs">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/agences">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/trajets">Trajets</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/touche-pas-au-klaxon/deconnexion" class="btn btn-danger btn-sm">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">Liste des Utilisateurs</h1>
            
            <!-- Notre nouvelle barre de recherche -->
            <form action="/touche-pas-au-klaxon/admin/utilisateurs" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Nom, prénom, email..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                
                <!-- Cette ligne invisible permet de garder le tri actif même quand on cherche -->
                <?php if(isset($_GET['sort'])): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">Chercher</button>
                
                <!-- Petit bouton rouge pour annuler la recherche -->
                <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="/touche-pas-au-klaxon/admin/utilisateurs" class="btn btn-outline-danger ms-2" title="Annuler la recherche">X</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th><a href="?sort=id_utilisateur" class="text-white text-decoration-none">ID ↕</a></th>
                                <th><a href="?sort=nom" class="text-white text-decoration-none">Nom ↕</a></th>
                                <th><a href="?sort=prenom" class="text-white text-decoration-none">Prénom ↕</a></th>
                                <th><a href="?sort=email" class="text-white text-decoration-none">Email ↕</a></th>
                                <th>Téléphone</th>
                                <th><a href="?sort=role" class="text-white text-decoration-none">Rôle ↕</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($utilisateurs as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id_utilisateur'] ?? $user['id']) ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($user['nom']) ?></td>
                                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                                    <td><a href="mailto:<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></a></td>
                                    <td><?= htmlspecialchars($user['telephone'] ?? 'Non renseigné') ?></td>
                                    <td>
                                        <?php if(isset($user['role']) && $user['role'] === 'admin'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Employé</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>
</html>