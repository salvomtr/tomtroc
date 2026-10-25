<?php /** @var string BASE_URL */ ?>
<?php /** @var \App\Entity\User $profil */ ?>
<?php /** @var \App\Entity\Book[] $livres */ ?>
<?php /** @var \App\Entity\User|null $user */ ?>

<div class="profil-public">

    <!-- Carte de l'utilisateur -->
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($profil->getPhotoOuDefaut()) ?>" alt="<?= htmlspecialchars($profil->getPrenom()) ?>">
        </div>

        <hr class="profil-separateur">

        <h1 class="profil-nom"><?= htmlspecialchars($profil->getPrenom()) ?></h1>
        <p class="membre-depuis">Membre depuis <?= $profil->getAnciennete() ?></p>
        <p class="bibliotheque-count">
            <span class="label">Bibliothèque</span><br>
            <i class="fa-solid fa-book-open" aria-hidden="true"></i>
            <?= count($livres) ?> livre<?= count($livres) > 1 ? 's' : '' ?>
        </p>

        <?php if (!$user || $user->getId() !== $profil->getId()): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $profil->getId() ?>" class="btn-secondary btn-ecrire">Écrire un message</a>
        <?php endif; ?>
    </div>

    <!-- Bibliothèque -->
    <div class="profil-livres">
        <?php if (empty($livres)): ?>
            <p class="livres-vide">Cet utilisateur n'a pas encore de livres.</p>
        <?php else: ?>
            <div class="livres-table">
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livres as $livre): ?>
                        <tr>
                            <td class="col-photo">
                                <img src="<?= bookImage($livre->getImage()) ?>" alt="">
                            </td>
                            <td class="col-titre">
                                <a href="<?= BASE_URL ?>/livres/<?= $livre->getId() ?>"><?= htmlspecialchars($livre->getTitre()) ?></a>
                            </td>
                            <td class="col-auteur"><?= htmlspecialchars($livre->getAuteur()) ?></td>
                            <td class="col-description"><?= htmlspecialchars($livre->getDescriptionCourte()) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>