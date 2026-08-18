<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer un trajet - Touche pas au Klaxon</title>
</head>
<body>
    <div style="background-color: #f0f0f0; padding: 10px;">
        <a href="/touche-pas-au-klaxon/">Retour à l'accueil</a>
    </div>

    <h1>Proposer un nouveau covoiturage</h1>

    <form action="/touche-pas-au-klaxon/trajet/ajouter" method="POST">
        
        <div>
            <label>Agence de départ :</label>
            <select name="id_agence_depart" required>
                <option value="">-- Choisissez une agence --</option>
                <!-- Le contrôleur enverra la liste des agences dans cette boucle -->
                <?php foreach($agences as $agence): ?>
                    <option value="<?= $agence['id_agence'] ?? $agence['id'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        
        <div>
            <label>Agence d'arrivée :</label>
            <select name="id_agence_arrivee" required>
                <option value="">-- Choisissez une agence --</option>
                <?php foreach($agences as $agence): ?>
                    <option value="<?= $agence['id_agence'] ?? $agence['id'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>

        <div>
            <label>Date et heure de départ :</label>
            <input type="datetime-local" name="date_heure_depart" required>
        </div>
        <br>

        <div>
            <label>Date et heure d'arrivée estimée :</label>
            <input type="datetime-local" name="date_heure_arrivee" required>
        </div>
        <br>

        <div>
            <label>Nombre de places au total :</label>
            <input type="number" name="places_total" min="1" max="8" required>
        </div>
        <br>

        <button type="submit">Publier mon trajet</button>
    </form>
</body>
</html>