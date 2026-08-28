<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Touche pas au Klaxon</title>
    <!-- Lien Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- HEADER ADMINISTRATEUR (Conforme aux exigences) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4"> 
        <div class="container-fluid px-4">
            <!-- À gauche : Le nom de l'application (lien vers le tableau de bord) -->
            <a class="navbar-brand fw-bold" href="/touche-pas-au-klaxon/admin/dashboard">⚙️ Touche pas au Klaxon (Admin)</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminMenu">
                <!-- À droite : Menu horizontal et bouton de déconnexion -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="/touche-pas-au-klaxon/admin/dashboard">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/touche-pas-au-klaxon/admin/utilisateurs">Utilisateurs</a>
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
        <!-- Zone des Messages Flash -->
        <?php if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Bienvenue, Administrateur</h1>
                <p class="text-muted">Depuis cet espace, vous avez la main sur l'ensemble de la plateforme.</p>
            </div>
        </div>
        
        <!-- On ajoutera les tableaux pour lister les données ici très bientôt ! -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text">Gérer la base des employés.</p>
                        <!-- <button class="btn btn-primary" disabled>Bientôt disponible</button> -->
                         <a href="/touche-pas-au-klaxon/admin/utilisateurs" class="btn btn-primary">Voir les utilisateurs</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Agences</h5>
                        <p class="card-text">Gérer les sites de l'entreprise.</p>
                        <!-- <button class="btn btn-primary" disabled>Bientôt disponible</button> -->

                        <a href="/touche-pas-au-klaxon/admin/agences" class="btn btn-primary">Gérer les agences</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Trajets</h5>
                        <p class="card-text">Superviser les covoiturages.</p>
                        <!-- <button class="btn btn-primary" disabled>Bientôt disponible</button> -->
                         <a href="/touche-pas-au-klaxon/admin/trajets" class="btn btn-primary">Gérer les trajets</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>