<?php /** @var string BASE_URL */ ?>
<?php /** @var \App\Entity\Book $livre */ ?>
<?php /** @var string|null $error */ ?>

<div class="livre-form-page">
    <a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← retour</a>

    <h1 class="livre-form-titre">Ajouter un livre</h1>

    <form method="POST" action="<?= BASE_URL ?>/livre/ajouter" enctype="multipart/form-data" class="livre-form">
        <?= csrfField() ?>

        <!-- Colonne gauche : photo -->
        <div class="livre-form-photo">
            <label for="image">Photo (facultatif)</label>
            <img src="<?= bookImage(null) ?>" alt="Aucune photo">
            <label for="image" class="lien-photo">Ajouter une photo</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" hidden>
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

            <button type="submit" class="btn-primary">Ajouter</button>
        </div>
    </form>
</div>