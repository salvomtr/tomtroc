<?php 
/** @var string BASE_URL */
/** @var string|null $error */
/** @var \App\Entity\User $user */
/** @var \App\Entity\Book[] $livres */
?>

<h1 class="compte-titre">Mon compte</h1>

<div class="compte-card">
    <!-- Partie gauche -->
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($user->getPhotoOuDefaut()) ?>" alt="Photo de profil">
            <a href="#">modifier</a>
        </div>

        <hr class="profil-separateur">

        <h2 class="profil-nom"><?= htmlspecialchars($user->getPrenom()) ?></h2>
        <p class="membre-depuis">Membre depuis <?= $user->getAnciennete() ?></p>
        <p class="bibliotheque-count">
            <span class="label">Bibliothèque</span><br>
            <i class="fa-solid fa-book-open"></i>
            <?= count($livres) ?> livre<?= count($livres) > 1 ? 's' : '' ?>
        </p>
    </div>

    <!-- Partie droite -->
    <div class="compte-infos">
        <h3>Vos informations personnelles</h3>
        <form method="POST" action="<?= BASE_URL ?>/mon-compte">
            <?php if (!empty($error)): ?>
                <p class="form-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <label>Adresse email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••">

            <label>Pseudo</label>
            <input type="text" name="pseudo" value="<?= htmlspecialchars($user->getPrenom()) ?>">

            <button type="submit" class="btn-secondary">Enregistrer</button>
        </form>
    </div>
</div>

<?php if (empty($livres)): ?>
    <p>Vous n'avez pas encore de livres dans votre bibliothèque.</p>
<?php endif; ?>

<!-- Tableau des livres -->
<div class="livres-table">
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Description</th>
                <th>Disponibilité</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($livres as $livre): ?>
            <tr>
                <td class="col-photo"><img src="<?= bookImage($livre->getImage()) ?>" alt="<?= htmlspecialchars($livre->getTitre()) ?>"></td>
                <td class="col-titre"><?= htmlspecialchars($livre->getTitre()) ?></td>
                <td class="col-auteur"><?= htmlspecialchars($livre->getAuteur()) ?></td>
                <td class="col-description"><?= htmlspecialchars($livre->getDescriptionCourte()) ?></td>         
                <td class="col-dispo">
                    <span class="badge <?= $livre->isDisponible() ? 'badge-green' : 'badge-red' ?>">
                        <?= $livre->isDisponible() ? 'disponible' : 'non dispo.' ?>
                    </span>
                </td>
                <td class="col-actions">
                    <a href="<?= BASE_URL ?>/livre/editer/<?= $livre->getId() ?>" class="lien-editer">Éditer</a>
                    <a href="<?= BASE_URL ?>/livre/supprimer/<?= $livre->getId() ?>" class="lien-supprimer"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="livres-actions">
    <a href="<?= BASE_URL ?>/livre/ajouter" class="btn-primary">Ajouter un livre</a>
</div>