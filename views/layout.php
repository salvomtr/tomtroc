<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($metaTitle) ? $metaTitle : "TomTroc" ?></title>
    <link rel="stylesheet" href="/tomtroc/public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="/tomtroc/" class="logo">
                <span class="logo-icon">TT</span>
                Tom Troc
            </a>
            <nav>
                <a href="/tomtroc/">Accueil</a>
                <a href="/tomtroc/livres">Nos livres à l'échange</a>
            </nav>
        </div>

        <div class="header-right">
            <a href="./messages">Messagerie</a>
            <a href="./mon-compte">Mon compte</a>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="./deconnexion">Déconnexion</a>
            <?php else: ?>
                <a href="/tomtroc/connexion">Connexion</a>
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
        <a href="/tomtroc/" class="logo">
            Tom Troc&copy;
            <span class="logo-icon">TT</span>
        </a>
    </footer>
</body>
</html>