<h1>Inscription</h1>

<form method="POST" action="<?= BASE_URL ?>/inscription">
    <label>Nom</label>
    <input type="text" name="nom" required>

    <label>Prénom</label>
    <input type="text" name="prenom" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <label>Date de naissance</label>
    <input type="date" name="date_naissance" required>

    <button type="submit">S'inscrire</button>
</form>