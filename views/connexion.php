<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Touche pas au Klaxon</title>
    <!-- Le fameux lien Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnToggle = document.getElementById('btnToggleMdp');
    const champMdp = document.getElementById('mot_de_passe');

    // On vérifie que les deux éléments existent bien sur la page pour éviter les erreurs
    if(btnToggle && champMdp) {
        btnToggle.addEventListener('click', function () {
            if (champMdp.type === 'password') {
                champMdp.type = 'text';
                this.textContent = '🙈'; 
            } else {
                champMdp.type = 'password';
                this.textContent = '👁️';
            }
        });
    }
});
</script>
<!-- "d-flex align-items-center" permet de centrer verticalement sur toute la hauteur de la page -->
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5"> <!-- On limite la largeur à 5 colonnes pour que ce ne soit pas trop étiré -->
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="h5 mb-0">🚗 Touche pas au Klaxon</h2>
                    </div>
                    
                    <div class="card-body p-4">
                        <h3 class="h4 text-center mb-4">Connexion</h3>
                        
                        <!-- Le message d'erreur devient une belle alerte rouge Bootstrap -->
                        <?php if(isset($erreur)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($erreur) ?>
                            </div>
                        <?php endif; ?>

                        <form action="/touche-pas-au-klaxon/connexion" method="POST">
                            <!-- Les champs de texte utilisent la classe "form-control" pour s'arrondir -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email :</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
                                    <button class="btn btn-outline-secondary" type="button" id="btnToggleMdp" title="Afficher/Masquer le mot de passe">👁️</button>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="/touche-pas-au-klaxon/" class="text-decoration-none">Retour à l'accueil</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>