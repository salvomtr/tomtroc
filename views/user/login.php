<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - TomTroc</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="/tomtroc/connexion">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Mot de passe</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>