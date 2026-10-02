<?php /** @var array $message */?>
<?php /** @var string BASE_URL */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Tomtroc</title>
</head>
<body>
    <h1>Conversation</h1>
    <p><?= $message['contenu'] ?></p>
    <p><?= $message['date_envoi'] ?></p>
    
    <a href="<?= BASE_URL ?>/messages">Retour aux messages</a>
</body>
</html>