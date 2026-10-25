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
            <?= csrfField() ?>
            <label for="prenom">Pseudo</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>

        <p>Déjà inscrit ? <a href="<?= BASE_URL ?>/connexion">Connectez-vous</a></p>
    </div>
    <div class="auth-image">
        <img src="<?= BASE_URL ?>/public/img/auth.png" alt="Bibliothèque">
    </div>
</div>