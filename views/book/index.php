<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos livres - TomTroc</title>
</head>
<body>
    <h1>Nos livres à l'echange</h1>
 <form method="GET" action="/tomtroc/livres">
        <input type="search" name="search" placeholder="Rechercher un livre...">
        <button type="submit">Rechercher</button>
    </form>

    <div>
        <?php foreach($livres as $livre): ?>
            <div>
                <h2><?= $livre['titre'] ?></h2>
                <p><?= $livre['auteur'] ?></p>
                <a href="/tomtroc/livres/<?= $livre['id'] ?>">Voir le détail</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>