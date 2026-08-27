<?php 
/** @var array $user */
/** @var array $livres */
?>
    <h1>Mon compte</h1>
    
    <h2><?= $user['prenom'] ?> <?= $user['nom'] ?></h2>
    <p><?= $user['email'] ?></p>
    
    <h2>Ma bibliothèque</h2>
    <a href="/tomtroc/livre/ajouter">Ajouter un livre</a>
    
    <div>
        <?php foreach($livres as $livre): ?>
            <div>
                <h3><?= $livre['titre'] ?></h3>
                <p><?= $livre['auteur'] ?></p>
                <a href="/tomtroc/livres/<?= $livre['id'] ?>">Voir</a>
            </div>
        <?php endforeach; ?>
    </div>
    
    <a href="/tomtroc/deconnexion">Se déconnecter</a>

