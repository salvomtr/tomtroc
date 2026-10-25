<?php

// Retourne l'URL de l'image d'un livre, ou l'image par défaut si elle est vide
function bookImage(?string $image): string
{
    if (empty($image)) {
        $image = 'default-book.png';
    }

    return BASE_URL . '/public/img/' . htmlspecialchars($image);
}

// Retourne le jeton CSRF de la session (il est créé la première fois)
// Le jeton est une chaîne aléatoire que seul notre site connaît
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

// Champ caché à placer dans chaque formulaire POST
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}