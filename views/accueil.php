<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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

    <!-- ZONE DES MESSAGES FLASH -->
    <div class="container">
        <?php if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Tableau de bord des trajets</h1>
            <a href="/touche-pas-au-klaxon/trajet/ajouter" class="btn btn-success">+ Proposer un trajet</a>
        </div>

        <div class="row">
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
                                        
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary rounded-pill me-3">
                                                <?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_total']) ?> places
                                            </span>
                                            
                                            <!-- Bouton Infos -->
                                            <button type="button" class="btn btn-sm btn-info text-white me-2" data-bs-toggle="modal" data-bs-target="#modalTrajet<?= $trajet['id_trajet'] ?>">
                                                Infos
                                            </button>
                                            
                                            <?php if(isset($_SESSION['utilisateur_id'])): ?>
                                                <?php if($_SESSION['utilisateur_id'] != $trajet['id_utilisateur']): ?>
                                                    <?php if($trajet['places_disponibles'] > 0): ?>
                                                        <form action="/touche-pas-au-klaxon/trajet/reserver" method="POST" style="margin: 0;">
                                                            <input type="hidden" name="id_trajet" value="<?= $trajet['id_trajet'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary">Réserver</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Complet</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted small"><em>Votre trajet</em></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </li>

                                    <!-- Fenêtre Modale Bootstrap pour ce trajet -->
                                    <div class="modal fade" id="modalTrajet<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">Détails du trajet</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['chauffeur_prenom'] . ' ' . $trajet['chauffeur_nom']) ?></p>
                                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['chauffeur_telephone'] ?? 'Non renseigné') ?></p>
                                            <p><strong>Email :</strong> <?= htmlspecialchars($trajet['chauffeur_email']) ?></p>
                                            <p><strong>Places au total :</strong> <?= htmlspecialchars($trajet['places_total']) ?></p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?> <!-- C'EST LUI QUI AVAIT DISPARU ! -->
                    </div>
                </div>
            </div>

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

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>