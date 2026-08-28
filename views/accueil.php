<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- HEADER -->
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

    <!-- CONTENU PRINCIPAL -->
    <div class="container mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🚗 Prochains covoiturages disponibles</h2>
            
            <!-- Le bouton pour ajouter n'apparaît que si l'employé est connecté -->
            <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
                <a href="/touche-pas-au-klaxon/trajet/ajouter" class="btn btn-success">+ Proposer un trajet</a>
            <?php endif; ?>
        </div>
    
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Départ</th>
                            <th>Date et Heure</th>
                            <th>Arrivée</th>
                            <th>Places dispo.</th>
                            <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
                                <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($trajets)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Aucun trajet n'est prévu pour le moment. Revenez plus tard !</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($trajets as $trajet): ?>
                                <tr>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                                    <td><?= date('d/m/Y à H:i', strtotime($trajet['date_heure_depart'])) ?></td>
                                    <td class="fw-bold text-success"><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark rounded-pill fs-6">
                                            <?= htmlspecialchars($trajet['places_disponibles']) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Les actions ne s'affichent que si l'utilisateur est connecté -->
                                    <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTrajet<?= $trajet['id_trajet'] ?>">Détails</button>
                                    </td>
                                    <?php endif; ?>
                                </tr>

                                <!-- FENÊTRE MODALE POUR CE TRAJET (Générée uniquement si connecté) -->
                                <?php if(isset($_SESSION['utilisateur_prenom'])): ?>
                                <div class="modal fade" id="modalTrajet<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Détails du trajet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['chauffeur_prenom'] . ' ' . $trajet['chauffeur_nom']) ?></p>
                                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['telephone'] ?? 'Non renseigné') ?></p>
                                        <p><strong>Email :</strong> <?= htmlspecialchars($trajet['email']) ?></p>
                                        <p><strong>Places au total :</strong> <?= htmlspecialchars($trajet['places_total']) ?></p>
                                      </div>
                                      <div class="modal-footer d-flex justify-content-between">
                                        <div>
                                            <!-- Si l'utilisateur connecté est l'auteur du trajet, on affiche les boutons de gestion -->
                                            <?php if($_SESSION['utilisateur_id'] == $trajet['id_utilisateur']): ?>
                                                <a href="/touche-pas-au-klaxon/trajet/modifier?id=<?= $trajet['id_trajet'] ?>" class="btn btn-sm btn-warning text-dark">Modifier</a>
                                                <form action="/touche-pas-au-klaxon/trajet/supprimer" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                                                    <input type="hidden" name="id_trajet" value="<?= $trajet['id_trajet'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>