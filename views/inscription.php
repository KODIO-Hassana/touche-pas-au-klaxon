<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6"> 
                
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h2 class="h5 mb-0">Créer un compte</h2>
                    </div>
                    
                    <div class="card-body p-4">
                        <?php if(isset($erreur)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($erreur) ?>
                            </div>
                        <?php endif; ?>

                        <form action="/touche-pas-au-klaxon/inscription" method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prénom :</label>
                                    <input type="text" class="form-control" name="prenom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nom :</label>
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Adresse email :</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Mot de passe :</label>
                                <input type="password" class="form-control" name="mot_de_passe" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">S'inscrire</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="/touche-pas-au-klaxon/connexion" class="text-decoration-none">J'ai déjà un compte, me connecter</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>