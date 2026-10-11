<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>
<?php /** @var array|null $user */ ?>

<div class="livre-show">
    <div class="livre-show-image">
        <img src="<?= BASE_URL ?>/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>">
    </div>
    <div class="livre-show-content">
        <h1><?= $livre['titre'] ?></h1>
        <p class="livre-auteur">par <?= htmlspecialchars($livre['auteur']) ?></p>
        
        <p class="label">DESCRIPTION</p>
        <p class="livre-description"><?= htmlspecialchars($livre['description']) ?></p>
        
        <p class="label">PROPRIÉTAIRE</p>
        <div class="proprietaire">
            <a href="<?= BASE_URL ?>/user/<?= $livre['user_id'] ?>">
                <?= htmlspecialchars($livre['prenom'] ?? '') ?>
            </a>
        </div>
        
        <?php if (!$user || $user['id'] != $livre['user_id']): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $livre['user_id'] ?>" class="btn-primary">Envoyer un message</a>
        <?php endif; ?>    
    </div>
</div>