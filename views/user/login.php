<?php /** @var string BASE_URL */ ?>
<?php /** @var string|null $error */ ?>

<div class="auth-page">
    <div class="auth-form">
        <h1>Connexion</h1>

        <?php if (!empty($error)): ?>
            <p class="form-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/connexion">
            <?= csrfField() ?>
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <p>Pas de compte ? <a href="<?= BASE_URL ?>/inscription">Inscrivez-vous</a></p>
    </div>
    <div class="auth-image">
        <img src="<?= BASE_URL ?>/public/img/auth.png" alt="Bibliothèque">
    </div>
</div>