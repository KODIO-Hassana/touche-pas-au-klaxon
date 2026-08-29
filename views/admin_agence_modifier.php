<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Agence - Admin</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="/touche-pas-au-klaxon/assets/scss/custom.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="/touche-pas-au-klaxon/admin/dashboard">⚙️ Touche pas au Klaxon (Admin)</a>
            <a href="/touche-pas-au-klaxon/admin/agences" class="btn btn-outline-light btn-sm">Retour aux agences</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h2 class="h5 mb-0 text-warning text-center">Modifier l'agence</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="/touche-pas-au-klaxon/admin/agences/modifier" method="POST">
                            <!-- Champ caché pour l'ID -->
                            <input type="hidden" name="id_agence" value="<?= htmlspecialchars($agence['id_agence'] ?? $agence['id']) ?>">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nom de la ville :</label>
                                <!-- On affiche le nom actuel dans l'attribut value -->
                                <input type="text" class="form-control" name="nom_agence" value="<?= htmlspecialchars($agence['nom']) ?>" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning fw-bold">Mettre à jour l'agence</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>