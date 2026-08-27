<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($metaTitle) ? $metaTitle : "TomTroc" ?></title>
    <link rel="stylesheet" href="/tomtroc/public/css/style.css">
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
            <?php if(isset($_SESSION['user'])): ?>
                <a href="/tomtroc/messages">Messagerie</a>
                <a href="/tomtroc/mon-compte">Mon compte</a>
                <a href="/tomtroc/deconnexion">Déconnexion</a>
            <?php else: ?>
                <a href="/tomtroc/connexion">Connexion</a>
                <a href="/tomtroc/inscription">Inscription</a>
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