<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
</head>
<body>
    <h1>Ajouter un livre</h1>
    
    <form method="POST" action="/tomtroc/livre/ajouter">
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
    
    <a href="/tomtroc/mon-compte">Retour à mon compte</a>
</body>
</html>