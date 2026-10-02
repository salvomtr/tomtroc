<h1>Ajouter un livre</h1>

<form method="POST" action="<?= BASE_URL ?>/livre/ajouter">
    <label>Titre</label>
    <input type="text" name="titre" required>

    <label>Auteur</label>
    <input type="text" name="auteur" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <label>Disponible à l'échange</label>
    <input type="checkbox" name="disponible" value="1" checked>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= BASE_URL ?>/mon-compte">Retour à mon compte</a>