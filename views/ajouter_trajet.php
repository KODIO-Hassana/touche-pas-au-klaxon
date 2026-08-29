<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un trajet - Touche pas au Klaxon</title>
    <!-- Notre lien magique Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="/touche-pas-au-klaxon/assets/scss/custom.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Barre de navigation simplifiée avec bouton de retour -->
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/touche-pas-au-klaxon/">🚗 Touche pas au Klaxon</a>
            <a href="/touche-pas-au-klaxon/" class="btn btn-outline-light btn-sm">Retour à l'accueil</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <!-- On utilise 8 colonnes sur 12 pour que le formulaire ait de la place -->
            <div class="col-md-8">
                
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 text-center">
                        <h2 class="h4 mb-0 text-success">Proposer un nouveau covoiturage</h2>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="/touche-pas-au-klaxon/trajet/ajouter" method="POST">
                            
                            <!-- Première ligne : Les Agences -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Agence de départ :</label>
                                    <!-- "form-select" applique un beau style de menu déroulant -->
                                    <select class="form-select" name="id_agence_depart" required>
                                        <option value="">-- Choisissez une agence --</option>
                                        <?php foreach($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?? $agence['id'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Agence d'arrivée :</label>
                                    <select class="form-select" name="id_agence_arrivee" required>
                                        <option value="">-- Choisissez une agence --</option>
                                        <?php foreach($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?? $agence['id'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Deuxième ligne : Les Dates -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Date et heure de départ :</label>
                                    <input type="datetime-local" class="form-control" name="date_heure_depart" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Arrivée estimée :</label>
                                    <input type="datetime-local" class="form-control" name="date_heure_arrivee" required>
                                </div>
                            </div>

                            <!-- Troisième ligne : Les Places -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nombre de places au total :</label>
                                <input type="number" class="form-control" name="places_total" min="1" max="8" required style="max-width: 150px;">
                            </div>

                            <hr class="mb-4">

                            <!-- Bouton de validation qui prend toute la largeur -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Publier mon trajet</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>