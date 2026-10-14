<?php /** @var string BASE_URL */ ?>
<?php /** @var array $conversations */ ?>
<?php /** @var array $messages */ ?>
<?php /** @var int|null $interlocuteurId */ ?>
<?php /** @var array|null $interlocuteur */ ?>
<?php /** @var array $user */ ?>
<?php /** @var string $vue */ ?>


<div class="messagerie messagerie-vue-<?= $vue ?>">

    <!-- Liste des conversations -->
    <div class="messagerie-liste">
        <h1>Messagerie</h1>
        <?php foreach($conversations as $conversation): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $conversation['id'] ?>"
               class="conversation-item <?= $conversation['id'] == $interlocuteurId ? 'active' : '' ?>">
                <div class="conversation-avatar">
                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($conversation['photo'] ?: 'img_profil.jpg') ?>" alt="<?= htmlspecialchars($conversation['prenom']) ?>">
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

        <?php if (empty($conversations)): ?>
            <p class="messagerie-liste-vide">Vous n'avez pas encore de conversation.</p>
        <?php endif; ?>
    </div>

    <!-- Fil de discussion -->
    <div class="messagerie-conversation">
        <a href="<?= BASE_URL ?>/messages" class="messagerie-retour">← Retour</a>

        <?php if ($interlocuteur): ?>
            <div class="conversation-entete">
                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($interlocuteur['photo'] ?: 'img_profil.jpg') ?>" alt="<?= htmlspecialchars($interlocuteur['prenom']) ?>">
                <span><?= htmlspecialchars($interlocuteur['prenom']) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($interlocuteurId === null): ?>
            <p class="messagerie-empty">Vous n'avez pas encore de conversation.</p>
        <?php elseif (empty($messages)): ?>
            <p class="messagerie-empty">Aucun message pour l'instant. Écrivez le premier !</p>
        <?php else: ?>
            <div class="fil-messages">
                <?php foreach($messages as $message): ?>
                    <div class="message <?= $message['user_id_expediteur'] == $user['id'] ? 'message-envoye' : 'message-recu' ?>">
                        <p class="message-contenu"><?= htmlspecialchars($message['contenu']) ?></p>
                        <div class="message-meta">
                            <?php if ($message['user_id_expediteur'] != $user['id']): ?>
                                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($interlocuteur['photo'] ?: 'img_profil.jpg') ?>" alt="">
                            <?php endif; ?>
                            <span class="message-date"><?= date('d.m H:i', strtotime($message['date_envoi'])) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($interlocuteurId !== null): ?>
            <form method="POST" action="<?= BASE_URL ?>/messages/<?= $interlocuteurId ?>" class="message-form">
                <textarea name="contenu" placeholder="Tapez votre message ici" required></textarea>
                <button type="submit" class="btn-primary">Envoyer</button>
            </form>
        <?php endif; ?>
    </div>

</div>