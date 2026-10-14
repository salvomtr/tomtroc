# TomTroc

TomTroc est un site qui permet à des lecteurs de partager leurs livres et de les échanger entre eux.

C'est mon projet de formation. Je l'ai fait en PHP sans framework, en utilisant le modèle MVC (Modèle - Vue - Contrôleur), avec une base de données MySQL et du CSS.

## Ce que fait le site

- On peut créer un compte et se connecter
- Dans "Mon compte", on peut modifier ses informations et gérer sa bibliothèque (ajouter, modifier et supprimer des livres)
- On peut voir le profil des autres membres
- La page "Nos livres à l'échange" affiche les livres disponibles, avec une recherche par titre
- On peut voir le détail d'un livre et contacter son propriétaire
- Il y a une messagerie pour discuter avec les autres membres

## Ce qu'il faut pour installer le projet

- PHP 8.1 ou plus récent
- MySQL ou MariaDB
- Moi j'ai utilisé XAMPP, qui contient déjà tout ça

## Installation

### 1. Télécharger le projet

```bash
git clone https://github.com/salvomtr/tomtroc.git
```

### 2. Créer la base de données

Dans phpMyAdmin, aller dans l'onglet **Importer**, choisir le fichier `database/tomtroc.sql` et cliquer sur **Exécuter**.

Ce fichier crée la base `tomtroc` avec les 3 tables (`users`, `books`, `messages`) et ajoute quelques utilisateurs, livres et messages pour pouvoir tester.

### 3. Configurer la connexion

Faire une copie du fichier `.env.local.php` et l'appeler `.env.php`.

Dans `.env.php`, remplir les informations de la base de données (en général avec XAMPP l'utilisateur est `root` sans mot de passe) et l'adresse du site dans `BASE_URL`.

### 4. Lancer le site

Attention : le site doit être lancé à la racine d'une adresse, par exemple `http://localhost:8000`. Il ne marche pas dans un sous-dossier comme `http://localhost/tomtroc`.

**Solution la plus simple** : ouvrir un terminal dans le dossier du projet et taper :

```bash
php -S localhost:8000
```

Ensuite ouvrir http://localhost:8000 dans le navigateur. Dans `.env.php`, mettre `BASE_URL` = `http://localhost:8000`.

**Autre solution (celle que j'ai utilisée)** : créer un virtual host dans XAMPP. J'ai ajouté ceci dans le fichier `C:\xampp\apache\conf\extra\httpd-vhosts.conf` :

```apache
<VirtualHost *:80>
    ServerName local.tomtroc.com
    DocumentRoot "C:/xampp/htdocs/tomtroc"
    <Directory "C:/xampp/htdocs/tomtroc">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Puis j'ai ajouté la ligne `127.0.0.1 local.tomtroc.com` dans le fichier `hosts` de Windows et j'ai redémarré Apache. Dans ce cas `BASE_URL` = `http://local.tomtroc.com`.

## Comptes pour tester

Tous les comptes ont le même mot de passe : `TomTroc2026!`

- nathalie@tomtroc.fr
- alex@tomtroc.fr
- sas@tomtroc.fr

Il y a déjà des messages entre ces comptes pour tester la messagerie.

## Organisation des dossiers

- `index.php` : c'est le point d'entrée, toutes les pages passent par ce fichier
- `Core/` : le routeur, qui regarde l'URL et appelle le bon contrôleur
- `Controller/` : les contrôleurs (accueil, livres, utilisateurs, messages)
- `Model/` : les modèles, qui font les requêtes SQL
- `views/` : les vues, c'est-à-dire le HTML des pages
- `public/` : le CSS, le JavaScript et les images
- `config/` : l'autoload des classes et la connexion à la base
- `database/` : le fichier SQL

Pour les routes, j'ai utilisé les attributs de PHP 8. Par exemple `#[Route('/livres/:id')]` au-dessus d'une méthode veut dire que cette méthode s'occupe de l'URL `/livres/1`, `/livres/2`, etc.

## Sécurité

J'ai fait attention à :

- hacher les mots de passe avec `password_hash()`
- utiliser des requêtes préparées pour éviter les injections SQL
- utiliser `htmlspecialchars()` quand j'affiche des données, pour éviter les failles XSS

