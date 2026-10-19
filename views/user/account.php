<?php 
/** @var string BASE_URL */
/** @var string|null $error */
/** @var array $user */
/** @var array $livres */
?>

<h1 class="compte-titre">Mon compte</h1>

<div class="compte-card">
    <!-- Partie gauche -->
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/<?= htmlspecialchars($user['photo'] ?: 'img_profil.jpg') ?>" alt="Photo de profil">
            <a href="#">modifier</a>
        </div>

        <hr class="profil-separateur">

        <h2 class="profil-nom"><?= htmlspecialchars($user['prenom']) ?></h2>
        <p class="membre-depuis">Membre depuis 1 an</p>
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
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••">

            <label>Pseudo</label>
            <input type="text" name="pseudo" value="<?= htmlspecialchars($user['prenom']) ?>">

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
                <td class="col-photo"><img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>"></td>
                <td class="col-titre"><?= htmlspecialchars($livre['titre']) ?></td>
                <td class="col-auteur"><?= htmlspecialchars($livre['auteur']) ?></td>
                <td class="col-description"><?= htmlspecialchars(mb_substr($livre['description'], 0, 80)) ?><?= mb_strlen($livre['description']) > 80 ? '…' : '' ?></td>         
                <td class="col-dispo">
                    <span class="badge <?= $livre['disponible'] ? 'badge-green' : 'badge-red' ?>">
                        <?= $livre['disponible'] ? 'disponible' : 'non dispo.' ?>
                    </span>
                </td>
                <td class="col-actions">
                    <a href="<?= BASE_URL ?>/livre/editer/<?= $livre['id'] ?>" class="lien-editer">Éditer</a>
                    <a href="<?= BASE_URL ?>/livre/supprimer/<?= $livre['id'] ?>" class="lien-supprimer"
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