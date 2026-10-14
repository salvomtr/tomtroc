<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livres */ ?>
<?php /** @var string $search */ ?>

<div class="livres-header">
    <h1>Nos livres à l'échange</h1>
    <form method="GET" action="<?= BASE_URL ?>/livres" class="search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" name="search" placeholder="Rechercher un livre"
               value="<?= htmlspecialchars($search ?? '') ?>" aria-label="Rechercher un livre">
    </form>
</div>

<?php if (empty($livres)): ?>
    <p class="livres-vide">
        <?= $search ? 'Aucun livre ne correspond à votre recherche.' : 'Aucun livre disponible pour le moment.' ?>
    </p>
<?php endif; ?>

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
