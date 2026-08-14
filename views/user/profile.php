<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=², initial-scale=1.0">
    <title>Profil - TomTroc</title>
</head>
<body>
    <h1><?= $user['prenom'] ?> <?= $user['nom'] ?></h1>
    
    <p><strong>Email:</strong> <?= $user['email'] ?></p>
    
    <a href="/tomtroc/messages">Envoyer un message</a>
    <a href="/tomtroc/">Retour à l'accueil</a>
</body>
</html>