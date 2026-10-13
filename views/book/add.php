<?php /** @var string BASE_URL */ ?>

<a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← Retour à mon compte</a>

<h1 class="livre-form-titre">Ajouter un livre</h1>

<form method="POST" action="<?= BASE_URL ?>/livre/ajouter" enctype="multipart/form-data" class="livre-form">
    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" required>

    <label for="auteur">Auteur</label>
    <input type="text" id="auteur" name="auteur" required>

    <label for="image">Image (facultatif)</label>
    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp">

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="8"></textarea>

    <label class="livre-form-checkbox">
        <input type="checkbox" name="disponible" value="1" checked>
        Disponible à l'échange
    </label>

    <button type="submit" class="btn-primary">Ajouter</button>
</form>