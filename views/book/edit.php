<?php /** @var string BASE_URL */ ?>
<?php /** @var \App\Entity\Book $livre */ ?>
<?php /** @var string|null $error */ ?>

<div class="livre-form-page">
    <a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← retour</a>

    <h1 class="livre-form-titre">Modifier les informations</h1>

    <form method="POST" action="" enctype="multipart/form-data" class="livre-form">
        <?= csrfField() ?>

        <!-- Colonne gauche : photo -->
        <div class="livre-form-photo">
            <p class="label-photo">Photo</p>
            <img src="<?= bookImage($livre->getImage()) ?>" alt="<?= htmlspecialchars($livre->getTitre()) ?>">
            <!-- Champ caché visuellement mais accessible au clavier (Tab puis Entrée) -->
            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" class="visually-hidden">
            <label for="image" class="lien-photo">Modifier la photo</label>
        </div>

        <!-- Colonne droite : champs -->
        <div class="livre-form-champs">
            <?php if (!empty($error)): ?>
                <p class="form-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre->getTitre()) ?>" maxlength="255" required>

            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre->getAuteur()) ?>" maxlength="255" required>

            <label for="description">Commentaire</label>
            <textarea id="description" name="description" rows="12" maxlength="5000"><?= htmlspecialchars($livre->getDescription() ?? '') ?></textarea>

            <label for="disponible">Disponibilité</label>
            <select id="disponible" name="disponible">
                <option value="1" <?= $livre->isDisponible() ? 'selected' : '' ?>>disponible</option>
                <option value="0" <?= !$livre->isDisponible() ? 'selected' : '' ?>>non dispo.</option>
            </select>

            <button type="submit" class="btn-primary">Valider</button>
        </div>
    </form>
</div>