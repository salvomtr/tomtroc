<?php /** @var string BASE_URL */ ?>

<div class="auth-page">
    <div class="auth-form">
        <h1>Inscription</h1>
        
        <form method="POST" action="<?= BASE_URL ?>/inscription">
            <label>Pseudo</label>
            <input type="text" name="prenom" required>

            <label>Adresse email</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>

        <p>Déjà inscrit ? <a href="<?= BASE_URL ?>/connexion">Connectez-vous</a></p>
    </div>
    <div class="auth-image">
        <img src="<?= BASE_URL ?>/public/img/auth.png" alt="Bibliothèque">
    </div>
</div>