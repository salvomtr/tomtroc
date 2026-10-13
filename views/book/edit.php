<?php /** @var string BASE_URL */ ?>
<?php /** @var array $livre */ ?>

<h1>Modifier un livre</h1>

<form method="POST" action="">
    <label>Titre</label>
    <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

    <label>Auteur</label>
    <input type="text" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($livre['description']) ?></textarea>

    <label>Disponible à l'échange</label>
    <input type="checkbox" name="disponible" value="1" <?= $livre['disponible'] ? 'checked' : '' ?>>

    <button type="submit" class="btn-primary">Enregistrer</button>
</form>

<a href="<?= BASE_URL ?>/mon-compte">Retour à mon compte</a>