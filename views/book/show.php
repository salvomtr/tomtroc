<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>

<div class="livre-show">
    <div class="livre-show-image">
        <img src="<?= BASE_URL ?>/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>">
    </div>
    <div class="livre-show-content">
        <h1><?= $livre['titre'] ?></h1>
        <p class="livre-auteur">par <?= $livre['auteur'] ?></p>
        
        <p class="label">DESCRIPTION</p>
        <p class="livre-description"><?= $livre['description'] ?></p>
        
        <p class="label">PROPRIÉTAIRE</p>
        <div class="proprietaire">
            <a href="<?= BASE_URL ?>/user/<?= $livre['user_id'] ?>">
                <?= $livre['prenom'] ?? '' ?> <?= $livre['nom'] ?? '' ?>
            </a>
        </div>
        
        <a href="<?= BASE_URL ?>/messages" class="btn-primary">Envoyer un message</a>
    </div>
</div>