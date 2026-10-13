<?php /** @var string BASE_URL */ ?>
<?php /** @var array $messages */ ?>
<?php /** @var array $conversations */ ?>
<?php /** @var array $user */ ?>
<?php /** @var bool $conversationOuverte */ ?>


<div class="messagerie">
    <div class="messagerie-liste">
        <h1>Messagerie</h1>
        <?php foreach($conversations as $conversation): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $conversation['id'] ?>" class="conversation-item">
                <div class="conversation-avatar">
                    <img src="<?= BASE_URL ?>/public/img/<?= $conversation['photo'] ?? 'img_profil.jpg' ?>" alt="<?= htmlspecialchars($conversation['prenom']) ?>">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <span class="conversation-nom"><?= htmlspecialchars($conversation['prenom']) ?></span>
                        <span class="conversation-date"><?= date('H:i', strtotime($conversation['date_envoi'])) ?></span>
                    </div>
                    <p class="conversation-preview"><?= htmlspecialchars($conversation['contenu']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="messagerie-conversation">

        <?php if (empty($messages)): ?>
            <p class="messagerie-empty">Aucun message pour l'instant</p>

            <?php else: ?>
                <div class="fil-messages">
                    <?php foreach($messages as $message): ?>
                        <div class="message <?= $message['user_id_expediteur'] == $user['id'] ? 'message-envoye' : 'message-recu' ?>">
                            <p class="message-contenu"><?= htmlspecialchars($message['contenu']) ?></p>
                            <span class="message-date"><?= date('d.m H:i', strtotime($message['date_envoi'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="message-form">
                <textarea name="contenu" placeholder="Tapez votre message ici" required></textarea>
                <button type="submit" class="btn-primary">Envoyer</button>
            </form>
    </div>
</div>