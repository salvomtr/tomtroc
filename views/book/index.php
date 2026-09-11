<?php /** @var array $livres */ ?>

<div class="livres-header">
    <h1>Nos livres à l'échange</h1>
    <form method="GET" action="/tomtroc/livres">
        <input type="search" name="search" placeholder="Rechercher un livre">
    </form>
</div>

<div class="livres-grid">
    <?php foreach($livres as $livre): ?>
        <a href="/tomtroc/livres/<?= $livre['id'] ?>">
            <div class="livre-card">
                <img src="/tomtroc/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>">
                <h3><?= $livre['titre'] ?></h3>
                <p><?= $livre['auteur'] ?></p>
                <p class="vendu-par">Vendu par : <?= $livre['prenom'] ?? '' ?> <?= $livre['nom'] ?? '' ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>