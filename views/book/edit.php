<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>

<div class="livre-form-page">
    <a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← retour</a>

    <h1 class="livre-form-titre">Modifier les informations</h1>

    <form method="POST" action="" enctype="multipart/form-data" class="livre-form">

        <!-- Colonne gauche : photo -->
        <div class="livre-form-photo">
            <label for="image">Photo</label>
            <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
            <label for="image" class="lien-photo">Modifier la photo</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" hidden>
        </div>

        <!-- Colonne droite : champs -->
        <div class="livre-form-champs">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>

            <label for="description">Commentaire</label>
            <textarea id="description" name="description" rows="12"><?= htmlspecialchars($livre['description']) ?></textarea>

            <label for="disponible">Disponibilité</label>
            <select id="disponible" name="disponible">
                <option value="1" <?= $livre['disponible'] ? 'selected' : '' ?>>disponible</option>
                <option value="0" <?= !$livre['disponible'] ? 'selected' : '' ?>>non dispo.</option>
            </select>

            <button type="submit" class="btn-primary">Valider</button>
        </div>
    </form>
</div>