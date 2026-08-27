<?php 
/** @var array $messages */
?>

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
