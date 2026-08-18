<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Touche pas au Klaxon</title>
</head>
<body>
    <h1>Se connecter</h1>
    
    <!-- Zone pour afficher l'erreur si le mot de passe est faux -->
    <?php if(isset($erreur)): ?>
        <p style="color: red; font-weight: bold;"><?= $erreur ?></p>
    <?php endif; ?>

    <form action="/touche-pas-au-klaxon/connexion" method="POST">
        <div>
            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <br>
        <button type="submit">Connexion</button>
    </form>
</body>
</html>