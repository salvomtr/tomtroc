<?php /** @var string BASE_URL */ ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($metaTitle) ? $metaTitle : "TomTroc" ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="<?= BASE_URL ?>/" class="logo">
                <span class="logo-icon">
                    <span class="logo-t1">T</span>
                    <span class="logo-t2">T</span>
                </span>
                Tom Troc
            </a>
            <nav>
                <a href="<?= BASE_URL ?>/">Accueil</a>
                <a href="<?= BASE_URL ?>/livres">Nos livres à l'échange</a>
            </nav>
        </div>

        <div class="header-right">
            <a href="<?= BASE_URL ?>/messages">
                <i class="fa-regular fa-comment"></i>
                Messagerie
            </a>
            <a href="<?= BASE_URL ?>/mon-compte">
                <i class="fa-regular fa-user"></i>
                Mon compte
            </a>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="<?= BASE_URL ?>/deconnexion">Déconnexion</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/connexion">Connexion</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <?= isset($content) ? $content : "" ?>
    </main>

    <footer>
        <nav>
            <a href="#">Politique de confidentialité</a>
            <a href="#">Mentions légales</a>
        </nav>
        <a href="<?= BASE_URL ?>/" class="logo">
            Tom Troc&copy;
            <span class="logo-icon">TT</span>
        </a>
    </footer>
</body>
</html>