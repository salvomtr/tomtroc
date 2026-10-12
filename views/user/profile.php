<?php /** @var string BASE_URL */ ?>
<?php /** @var array $profil */ ?>
<?php /** @var array $livres */ ?>
<?php /** @var array|null $user */ ?>

<div class="compte-card">
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($profil['photo'] ?: 'img_profil.jpg') ?>" alt="<?= htmlspecialchars($profil['prenom']) ?>">
        </div>
    
        <h2><?= htmlspecialchars($profil['prenom']) ?></h2>
        <p class="bibliotheque-count">BIBLIOTHÈQUE<br><?= count($livres) ?> livres</p>

        <?php if (!$user || $user['id'] != $profil['id']): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $profil['id'] ?>" class="btn-primary">Écrire un message</a>
        <?php endif; ?>
    </div>        
</div>

<?php if (empty($livres)): ?>
    <p>Cet utilisateur n'a pas encore de livres.</p>
<?php endif; ?>

<div class="livres-grid">
    <?php foreach ($livres as $livre): ?>
        <a href="<?= BASE_URL ?>/livres/<?= $livre['id'] ?>">
            <div class="livre-card">
                <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                <p><?= htmlspecialchars($livre['auteur']) ?></p>
                <span class="badge <?= $livre['disponible'] ? 'badge-green' : 'badge-red' ?>">
                    <?= $livre['disponible'] ? 'disponible' : 'non dispo' ?>
                </span>
            </div>
        </a>
    <?php endforeach; ?>
</div>
