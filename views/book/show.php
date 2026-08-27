<?php 
/** @var array $livre */
?>
    
    <h1><?= $livre['titre'] ?></h1>
    <p><strong>Auteur:</strong> <?= $livre['auteur'] ?></p>
    <p><strong>Description:</strong> <?= $livre['description'] ?></p>
    <p><strong>Disponible:</strong> <?= $livre['disponible'] ? 'Oui' : 'Non' ?></p>
    
    <a href="/tomtroc/user/<?= $livre['user_id'] ?>">Voir le profil du propriétaire</a>
    <a href="/tomtroc/messages">Envoyer un message</a>
    
    <a href="/tomtroc/livres">Retour aux livres</a>
