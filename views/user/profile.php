<?php /** @var array $user */ ?>

<h1><?= $user['prenom'] ?> <?= $user['nom'] ?></h1>

<p><strong>Email:</strong> <?= $user['email'] ?></p>

<a href="<?= BASE_URL ?>/messages">Envoyer un message</a>
<a href="<?= BASE_URL ?>/">Retour à l'accueil</a>