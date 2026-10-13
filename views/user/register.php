<?php /** @var string BASE_URL */ ?>
<?php /** @var string|null $error */ ?>
<?php /** @var string|null $prenom */ ?>
<?php /** @var string|null $email */ ?>

<div class="auth-page">
    <div class="auth-form">
        <h1>Inscription</h1>

        <?php if (!empty($error)): ?>
            <p class="form-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/inscription">
            <label>Pseudo</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" required>

            <label>Adresse email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>

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