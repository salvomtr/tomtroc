<?php /** @var string BASE_URL */ ?>
<?php /** @var \App\Entity\Book $livre */ ?>
<?php /** @var \App\Entity\User|null $user */ ?>

<nav class="fil-ariane">
    <a href="<?= BASE_URL ?>/livres">Nos livres</a> &gt; <?= htmlspecialchars($livre->getTitre()) ?>
</nav>

<div class="livre-show">
    <div class="livre-show-image">
        <img src="<?= bookImage($livre->getImage()) ?>" alt="<?= htmlspecialchars($livre->getTitre()) ?>">
    </div>

    <div class="livre-show-content">
        <h1><?= htmlspecialchars($livre->getTitre()) ?></h1>
        <p class="livre-auteur">par <?= htmlspecialchars($livre->getAuteur()) ?></p>
        <hr class="livre-separateur">

        <p class="label">Description</p>
        <p class="livre-description"><?= nl2br(htmlspecialchars($livre->getDescription() ?? '')) ?></p>

        <p class="label">Propriétaire</p>
        <a href="<?= BASE_URL ?>/user/<?= $livre->getUserId() ?>" class="proprietaire">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($livre->getProprietairePhoto() ?: 'img_profil.jpg') ?>" alt="">
            <span><?= htmlspecialchars($livre->getProprietairePrenom()) ?></span>
        </a>

        <?php if (!$user || $user->getId() !== $livre->getUserId()): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $livre->getUserId() ?>" class="btn-primary btn-message">Envoyer un message</a>
        <?php endif; ?>
    </div>
</div>