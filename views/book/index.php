<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livres */ ?>

<div class="livres-header">
    <h1>Nos livres à l'échange</h1>
    <form method="GET" action="<?= BASE_URL ?>/livres">
        <input type="search" name="search" placeholder="Rechercher un livre">
    </form>
</div>

<div class="livres-grid">
    <?php foreach($livres as $livre): ?>
        <a href="<?= BASE_URL ?>/livres/<?= $livre['id'] ?>">
            <div class="livre-card">
                <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                <p><?= htmlspecialchars($livre['auteur']) ?></p>
                <p class="vendu-par">Vendu par : <?= htmlspecialchars($livre['prenom'] ?? '') ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>
