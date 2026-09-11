<?php /** @var array $derniers_livres */ ?>

<section class="hero">
    <div class="hero-text">
        <h1>Rejoignez nos lecteurs passionnés</h1>
        <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. 
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
        <a href="/tomtroc/livres" class="btn-primary">Découvrir</a>
    </div>
    <div class="hero-image">
        <img src="/tomtroc/public/img/hero.png" alt="Librairie">
    </div>
</section>

<section class="derniers-livres">
    <h2>Les derniers livres ajoutés</h2>
    <div class="livres-grid">
        <?php foreach($derniers_livres as $livre): ?>
            <a href="/tomtroc/livres/<?= $livre['id'] ?>">
                <div class="livre-card">
                    <img src="/tomtroc/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>">
                    <h3><?= $livre['titre'] ?></h3>
                    <p><?= $livre['auteur'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <a href="/tomtroc/livres" class="btn-primary">Voir tous les livres</a>
</section>

