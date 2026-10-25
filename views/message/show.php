<?php /** @var string BASE_URL */ ?>
<?php /** @var \App\Entity\Message[] $conversations */ ?>
<?php /** @var \App\Entity\Message[] $messages */ ?>
<?php /** @var int|null $interlocuteurId */ ?>
<?php /** @var \App\Entity\User|null $interlocuteur */ ?>
<?php /** @var \App\Entity\User $user */ ?>
<?php /** @var string $vue */ ?>


<div class="messagerie messagerie-vue-<?= $vue ?>">

    <!-- Liste des conversations -->
    <div class="messagerie-liste">
        <h1>Messagerie</h1>
        <?php foreach($conversations as $conversation): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $conversation->getInterlocuteurId() ?>"
               class="conversation-item <?= $conversation->getInterlocuteurId() === $interlocuteurId ? 'active' : '' ?>">
                <div class="conversation-avatar">
                    <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($conversation->getInterlocuteurPhoto() ?: 'img_profil.jpg') ?>" alt="<?= htmlspecialchars($conversation->getInterlocuteurPrenom()) ?>">
                </div>
                <div class="conversation-info">
                    <div class="conversation-header">
                        <span class="conversation-nom"><?= htmlspecialchars($conversation->getInterlocuteurPrenom()) ?></span>
                        <span class="conversation-date"><?= date('H:i', strtotime($conversation->getDateEnvoi())) ?></span>
                    </div>
                    <p class="conversation-preview"><?= htmlspecialchars($conversation->getContenu()) ?></p>
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
                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($interlocuteur->getPhotoOuDefaut()) ?>" alt="<?= htmlspecialchars($interlocuteur->getPrenom()) ?>">
                <span><?= htmlspecialchars($interlocuteur->getPrenom()) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($interlocuteurId === null): ?>
            <p class="messagerie-empty">Vous n'avez pas encore de conversation.</p>
        <?php elseif (empty($messages)): ?>
            <p class="messagerie-empty">Aucun message pour l'instant. Écrivez le premier !</p>
        <?php else: ?>
            <div class="fil-messages">
                <?php foreach($messages as $message): ?>
                    <div class="message <?= $message->estEnvoyePar($user->getId()) ? 'message-envoye' : 'message-recu' ?>">
                        <p class="message-contenu"><?= htmlspecialchars($message->getContenu()) ?></p>
                        <div class="message-meta">
                            <?php if (!$message->estEnvoyePar($user->getId())): ?>
                                <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($interlocuteur->getPhotoOuDefaut()) ?>" alt="">
                            <?php endif; ?>
                            <span class="message-date"><?= date('d.m H:i', strtotime($message->getDateEnvoi())) ?></span>
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