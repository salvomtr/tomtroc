<?php 
/** @var array $user */
/** @var array $livres */
/** @var string BASE_URL */
?>

<h1>Mon compte</h1>

<div class="compte-card">
    <!-- Partie gauche -->
    <div class="compte-profil">
        <div class="profil-photo">
            <img src="<?= BASE_URL ?>/public/img/img_profil.jpg" alt="Photo de profil">
            <a href="#">modifier</a>
        </div>
        <h2><?= $user['prenom'] ?></h2>
        <p class="membre-depuis">Membre depuis 1 an</p>
        <p class="bibliotheque-count">BIBLIOTHÈQUE<br><?= count($livres) ?> livres</p>
    </div>

    <!-- Partie droite -->
    <div class="compte-infos">
        <h3>Vos informations personnelles</h3>
        <form method="POST" action="<?= BASE_URL ?>/mon-compte">
            <label>Adresse email</label>
            <input type="email" name="email" value="<?= $user['email'] ?>">

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••">

            <label>Pseudo</label>
            <input type="text" name="pseudo" value="<?= $user['prenom'] ?>">

            <button type="submit" class="btn-secondary">Enregistrer</button>
        </form>
    </div>
</div>

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
                <td><img src="<?= BASE_URL ?>/public/img/<?= $livre['image'] ?>" alt="<?= $livre['titre'] ?>"></td>
                <td><?= $livre['titre'] ?></td>
                <td><?= $livre['auteur'] ?></td>
                <td><?= substr($livre['description'], 0, 50) ?>...</td>
                <td>
                    <span class="badge <?= $livre['disponible'] ? 'badge-green' : 'badge-red' ?>">
                        <?= $livre['disponible'] ? 'disponible' : 'non dispo' ?>
                    </span>
                </td>
                <td>
                    <a href="<?= BASE_URL ?>/livre/editer/<?= $livre['id'] ?>">Éditer</a>
                    <a href="<?= BASE_URL ?>/livre/supprimer/<?= $livre['id'] ?>">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
