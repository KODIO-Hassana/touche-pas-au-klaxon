<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Agences - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="#">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/touche-pas-au-klaxon/admin/agences">Agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Trajets</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/touche-pas-au-klaxon/deconnexion" class="btn btn-danger btn-sm">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Gestion des Agences</h1>
            <a href="#" class="btn btn-success">+ Ajouter une agence</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom de la ville (Agence)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($agences as $agence): ?>
                            <tr>
                                <td><?= htmlspecialchars($agence['id_agence'] ?? $agence['id']) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($agence['nom']) ?></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-warning">Modifier</button>
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
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