<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>

<a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← Retour à mon compte</a>

<h1 class="livre-form-titre">Modifier les informations</h1>

<form method="POST" action="" enctype="multipart/form-data" class="livre-form">
    <label>Image actuelle</label>
    <img src="<?= bookImage($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>" class="livre-form-image">

    <label for="image">Nouvelle image (facultatif)</label>
    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">

    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

    <label for="auteur">Auteur</label>
    <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="8"><?= htmlspecialchars($livre['description']) ?></textarea>

    <label class="livre-form-checkbox">
        <input type="checkbox" name="disponible" value="1" <?= $livre['disponible'] ? 'checked' : '' ?>>
        Disponible à l'échange
    </label>

    <button type="submit" class="btn-primary">Valider</button>
</form>