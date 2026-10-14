<?php /** @var string BASE_URL */ ?>

<div class="livre-form-page">
    <a href="<?= BASE_URL ?>/mon-compte" class="lien-retour">← retour</a>

    <h1 class="livre-form-titre">Ajouter un livre</h1>

    <form method="POST" action="<?= BASE_URL ?>/livre/ajouter" enctype="multipart/form-data" class="livre-form">

        <!-- Colonne gauche : photo -->
        <div class="livre-form-photo">
            <label for="image">Photo (facultatif)</label>
            <img src="<?= bookImage(null) ?>" alt="Aucune photo">
            <label for="image" class="lien-photo">Ajouter une photo</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/webp" hidden>
        </div>

        <!-- Colonne droite : champs -->
        <div class="livre-form-champs">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required>

            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" required>

            <label for="description">Commentaire</label>
            <textarea id="description" name="description" rows="12"></textarea>

            <label for="disponible">Disponibilité</label>
            <select id="disponible" name="disponible">
                <option value="1" selected>disponible</option>
                <option value="0">non dispo.</option>
            </select>

            <button type="submit" class="btn-primary">Ajouter</button>
        </div>
    </form>
</div>