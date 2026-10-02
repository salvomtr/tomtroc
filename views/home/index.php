<?php /** @var string BASE_URL */ ?>
<?php /** @var array $derniers_livres */ ?>

<section class="hero">
    <div class="hero-text">
        <h1>Rejoignez nos lecteurs passionnés</h1>
        <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. 
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
        <a href="<?= BASE_URL ?>/livres" class="btn-primary">Découvrir</a>
    </div>
    <div class="hero-image">
        <img src="<?= BASE_URL ?>/public/img/hero.png" alt="Librairie">
    </div>
</section>

<section class="derniers-livres">
    <h2>Les derniers livres ajoutés</h2>
    <div class="livres-grid">
        <?php foreach($derniers_livres as $livre): ?>
            <a href="<?= BASE_URL ?>/livres/<?= $livre['id'] ?>">
                <div class="livre-card">
                    <img src="<?= BASE_URL ?>/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>">
                    <h3><?= $livre['titre'] ?></h3>
                    <p><?= $livre['auteur'] ?></p>
                    <p class="vendu-par">Vendu par : <?= $livre['prenom'] ?> <?= $livre['nom'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <a href="<?= BASE_URL ?>/livres" class="btn-primary">Voir tous les livres</a>
</section>

<section class="comment-ca-marche">
    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :</p>
    <div class="etapes">
        <div class="etape">Inscrivez-vous gratuitement sur notre plateforme.</div>
        <div class="etape">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
        <div class="etape">Parcourez les livres disponibles chez d'autres membres.</div>
        <div class="etape">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
    </div>
    <a href="<?= BASE_URL ?>/livres" class="btn-secondary">Voir tous les livres</a>
</section>

<section class="banner-image">
    <img src="<?= BASE_URL ?>/public/img/banner.png" alt="Bibliothèque">
</section>

<section class="nos-valeurs">
    <h2>Nos valeurs</h2>
    <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
    <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
    <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
    <div class="signature-row">
        <p class="signature">L'équipe Tom Troc</p>
        <img src="<?= BASE_URL ?>/public/img/heart.png" alt="coeur">
    </div>
</section>