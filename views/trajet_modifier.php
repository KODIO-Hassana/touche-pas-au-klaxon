<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un trajet - Touche pas au Klaxon</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="/touche-pas-au-klaxon/assets/scss/custom.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- <?php include 'partials/header.php'; ?> -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">✏️ Modifier le trajet</h4>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($erreur)): ?>
                        <div class="alert alert-danger"><?= $erreur ?></div>
                    <?php endif; ?>

                    <form action="/touche-pas-au-klaxon/trajet/modifier" method="POST">
                        <!-- CHAMP CACHÉ CRUCIAL : Il permet au contrôleur de savoir QUEL trajet modifier -->
                        <input type="hidden" name="id_trajet" value="<?= htmlspecialchars($trajet['id_trajet']) ?>">

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Conducteur</label>
                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars(trim(($_SESSION['utilisateur_prenom'] ?? '') . ' ' . ($_SESSION['utilisateur_nom'] ?? ''))) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email de contact</label>
                                <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($_SESSION['utilisateur_email'] ?? '') ?>" readonly>
                            </div>
                        </div>

                        <h5 class="mb-3">Détails du covoiturage</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_agence_depart" class="form-label">Ville de départ *</label>
                                <select class="form-select" id="id_agence_depart" name="id_agence_depart" required>
                                    <option value="">-- Choisir une agence --</option>
                                    <?php foreach ($agences as $agence): ?>
                                        <!-- Astuce : On ajoute 'selected' si l'ID correspond à l'ancienne valeur du trajet -->
                                        <option value="<?= $agence['id_agence'] ?>" <?= ($agence['id_agence'] == $trajet['id_agence_depart']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($agence['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_agence_arrivee" class="form-label">Ville d'arrivée *</label>
                                <select class="form-select" id="id_agence_arrivee" name="id_agence_arrivee" required>
                                    <option value="">-- Choisir une agence --</option>
                                    <?php foreach ($agences as $agence): ?>
                                        <option value="<?= $agence['id_agence'] ?>" <?= ($agence['id_agence'] == $trajet['id_agence_arrivee']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($agence['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="date_heure_depart" class="form-label">Départ *</label>
                                <input type="datetime-local" class="form-control" id="date_heure_depart" name="date_heure_depart" value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_heure_depart'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="date_heure_arrivee" class="form-label">Arrivée *</label>
                                <input type="datetime-local" class="form-control" id="date_heure_arrivee" name="date_heure_arrivee" value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_heure_arrivee'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="places_total" class="form-label">Places dispo. *</label>
                                <input type="number" class="form-control" id="places_total" name="places_total" min="1" max="8" value="<?= htmlspecialchars($trajet['places_total']) ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="/touche-pas-au-klaxon/" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning">Enregistrer les modifications</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>