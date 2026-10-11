<?php /** @var string BASE_URL */ ?>
<?php /** @var array $messages */ ?>
<?php /** @var array $conversations */ ?>
<?php /** @var array $user */ ?>


<div class="messagerie">
    <div class="messagerie-liste">
        <h1>Messagerie</h1>
        <?php foreach($conversations as $conversation): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $conversation['id'] ?>" class="conversation-item">
                <div class="conversation-avatar">
                    <img src="<?= BASE_URL ?>/public/img/<?= $message['photo'] ?? 'img_profil.jpg' ?>" alt="<?= $conversation['prenom'] ?>">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <span class="conversation-nom"><?= $conversation['prenom'] ?></span>
                        <span class="conversation-date"><?= date('H:i', strtotime($conversation['date_envoi'])) ?></span>
                    </div>
                    <p class="conversation-preview"><?= substr($conversation['contenu'], 0, 30) ?>...</p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="messagerie-conversation">

        <?php if (empty($messages)): ?>
            <p class="messagerie-empty">Sélectionnez une conversation</p>

        <?php else: ?>
            <div class="fil-messages">
                <?php foreach($messages as $message): ?>
                    <div class="message <?= $message['user_id_expediteur'] == $user['id'] ? 'message-envoye' : 'message-recu' ?>">
                        <p class="message-contenu"><?= $message['contenu'] ?></p>
                        <span class="message-date"><?= date('d.m H:i', strtotime($message['date_envoi'])) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>