<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>
<?php /** @var array|null $user */ ?>

<nav class="fil-ariane">
    <a href="<?= BASE_URL ?>/livres">Nos livres</a> &gt; <?= htmlspecialchars($livre['titre']) ?>
</nav>

<div class="livre-show">
    <div class="livre-show-image">
        <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
    </div>

    <div class="livre-show-content">
        <h1><?= htmlspecialchars($livre['titre']) ?></h1>
        <p class="livre-auteur">par <?= htmlspecialchars($livre['auteur']) ?></p>
        <hr class="livre-separateur">

        <p class="label">Description</p>
        <p class="livre-description"><?= nl2br(htmlspecialchars($livre['description'])) ?></p>

        <p class="label">Propriétaire</p>
        <a href="<?= BASE_URL ?>/user/<?= $livre['user_id'] ?>" class="proprietaire">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($livre['photo'] ?: 'img_profil.jpg') ?>" alt="">
            <span><?= htmlspecialchars($livre['prenom']) ?></span>
        </a>

        <?php if (!$user || $user['id'] != $livre['user_id']): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $livre['user_id'] ?>" class="btn-primary btn-message">Envoyer un message</a>
        <?php endif; ?>
    </div>
</div>