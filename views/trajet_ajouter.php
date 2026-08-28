<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un trajet - Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Reprends ton Header de navigation habituel ici -->
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">🚗 Proposer un nouveau trajet</h2>
                    </div>
                    <div class="card-body">
                        
                        <!-- Zone d'erreur potentielle -->
                        <?php if(isset($erreur)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
                        <?php endif; ?>

                        <form action="/touche-pas-au-klaxon/trajet/ajouter" method="POST">
                            
                            <h5 class="mb-3 text-secondary">Vos informations (Pré-renseignées)</h5>
                            <div class="row mb-4">
                                <!-- Champs en lecture seule (readonly) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Conducteur</label>
                                    <input type="text" class="form-control bg-light" value="<?= htmlspecialchars(trim(($_SESSION['utilisateur_prenom'] ?? '') . ' ' . ($_SESSION['utilisateur_nom'] ?? ''))) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email de contact</label>
                                    <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($_SESSION['utilisateur_email'] ?? '') ?>" readonly>
                                </div>
                            </div>

                            <h5 class="mb-3 text-secondary">Détails du covoiturage</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="id_agence_depart" class="form-label">Ville de départ <span class="text-danger">*</span></label>
                                    <select name="id_agence_depart" id="id_agence_depart" class="form-select" required>
                                        <option value="">-- Choisir une agence --</option>
                                        <?php foreach($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="id_agence_arrivee" class="form-label">Ville d'arrivée <span class="text-danger">*</span></label>
                                    <select name="id_agence_arrivee" id="id_agence_arrivee" class="form-select" required>
                                        <option value="">-- Choisir une agence --</option>
                                        <?php foreach($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date_heure_depart" class="form-label">Départ <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="date_heure_depart" id="date_heure_depart" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="date_heure_arrivee" class="form-label">Arrivée <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="date_heure_arrivee" id="date_heure_arrivee" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="places_total" class="form-label">Places dispo. <span class="text-danger">*</span></label>
                                    <input type="number" name="places_total" id="places_total" class="form-control" min="1" max="8" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="/touche-pas-au-klaxon/" class="btn btn-outline-secondary me-2">Annuler</a>
                                <button type="submit" class="btn btn-success">Publier le trajet</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>