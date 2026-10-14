<?php /** @var string BASE_URL */ ?>
<?php /** @var array $profil */ ?>
<?php /** @var array $livres */ ?>
<?php /** @var array|null $user */ ?>

<div class="profil-public">

    <!-- Carte de l'utilisateur -->
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($profil['photo'] ?: 'img_profil.jpg') ?>" alt="<?= htmlspecialchars($profil['prenom']) ?>">
        </div>

        <hr class="profil-separateur">

        <h2 class="profil-nom"><?= htmlspecialchars($profil['prenom']) ?></h2>
        <p class="membre-depuis">Membre depuis 1 an</p>
        <p class="bibliotheque-count">
            <span class="label">Bibliothèque</span><br>
            <i class="fa-solid fa-book-open"></i>
            <?= count($livres) ?> livre<?= count($livres) > 1 ? 's' : '' ?>
        </p>

        <?php if (!$user || $user['id'] != $profil['id']): ?>
            <a href="<?= BASE_URL ?>/messages/<?= $profil['id'] ?>" class="btn-secondary btn-ecrire">Écrire un message</a>
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
                                <a href="<?= BASE_URL ?>/livres/<?= $livre['id'] ?>">
                                    <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
                                </a>
                            </td>
                            <td class="col-titre">
                                <a href="<?= BASE_URL ?>/livres/<?= $livre['id'] ?>"><?= htmlspecialchars($livre['titre']) ?></a>
                            </td>
                            <td class="col-auteur"><?= htmlspecialchars($livre['auteur']) ?></td>
                            <td class="col-description"><?= htmlspecialchars(mb_substr($livre['description'], 0, 80)) ?><?= mb_strlen($livre['description']) > 80 ? '…' : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>