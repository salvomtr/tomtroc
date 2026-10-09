<?php /** @var string BASE_URL */ ?>

<div class="auth-page">
    <div class="auth-form">
        <h1>Connexion</h1>
        
        <form method="POST" action="<?= BASE_URL ?>/connexion">
            <label>Adresse email</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <p>Pas de compte ? <a href="<?= BASE_URL ?>/inscription">Inscrivez-vous</a></p>
    </div>
    <div class="auth-image">
        <img src="<?= BASE_URL ?>/public/img/auth.png" alt="Bibliothèque">
    </div>
</div>