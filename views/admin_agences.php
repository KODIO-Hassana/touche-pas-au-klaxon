<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Agences - Admin</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="/touche-pas-au-klaxon/assets/scss/custom.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- LE MÊME HEADER QUE LE DASHBOARD -->
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
                        <a class="nav-link active" href="/touche-pas-au-klaxon/admin/agences">Agences</a>
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

           <!-- Zone des Messages Flash -->
        <?php if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
        
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">Gestion des Agences</h1>
            
            <!-- Barre de recherche -->
            <form action="/touche-pas-au-klaxon/admin/agences" method="GET" class="d-flex mx-auto my-2 my-md-0">
                <input type="text" name="search" class="form-control me-2" placeholder="Chercher une ville..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <?php if(isset($_GET['sort'])): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Chercher</button>
                <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="/touche-pas-au-klaxon/admin/agences" class="btn btn-outline-danger ms-2" title="Annuler">X</a>
                <?php endif; ?>
            </form>

            <a href="/touche-pas-au-klaxon/admin/agences/ajouter" class="btn btn-success">+ Ajouter une agence</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th><a href="?sort=id_agence" class="text-white text-decoration-none">ID ↕</a></th>
                            <th><a href="?sort=nom" class="text-white text-decoration-none">Nom de la ville (Agence) ↕</a></th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($agences as $agence): ?>
                            <tr>
                                <td><?= htmlspecialchars($agence['id_agence'] ?? $agence['id']) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($agence['nom']) ?></td>
                                <!-- <td class="text-end">
                                    <button class="btn btn-sm btn-warning">Modifier</button>
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </td> -->
                                <td class="text-end">
                                    <!-- Bouton Modifier -->
                                    <a href="/touche-pas-au-klaxon/admin/agences/modifier?id=<?= $agence['id_agence'] ?? $agence['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    
                                    <!-- Bouton Supprimer avec alerte -->
                                    <form action="/touche-pas-au-klaxon/admin/agences/supprimer" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?');">
                                        <input type="hidden" name="id_agence" value="<?= $agence['id_agence'] ?? $agence['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>