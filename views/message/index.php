<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes messages</title>
</head>
<body>
    <h1>Mes messages</h1>
    <div>
        <?php foreach($messages as $message): ?>
            <div>
                <p><?= $message['contenu'] ?></p>
                <p><?= $message['date_envoi'] ?></p>
                <a href="/tomtroc/messages/<?= $message['id'] ?>">Voir la conversation</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>