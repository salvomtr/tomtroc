<h1>Connexion</h1>
<form method="POST" action="<?= BASE_URL ?>/connexion">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>