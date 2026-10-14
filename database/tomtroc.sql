CREATE DATABASE IF NOT EXISTS tomtroc
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE tomtroc;

-- Suppression dans l'ordre inverse des dépendances
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

-- ------------------------------------------------------------
-- Table users
-- ------------------------------------------------------------
CREATE TABLE users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prenom     VARCHAR(100) NOT NULL,
    email      VARCHAR(255) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    photo      VARCHAR(255) NULL DEFAULT NULL,
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table books
-- ------------------------------------------------------------
CREATE TABLE books (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id     INT UNSIGNED NOT NULL,
    titre       VARCHAR(255) NOT NULL,
    auteur      VARCHAR(255) NOT NULL,
    image       VARCHAR(255) NULL DEFAULT NULL,
    description TEXT         NULL,
    disponible  TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    KEY idx_books_user (user_id),
    CONSTRAINT fk_books_user FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Table messages
-- ------------------------------------------------------------
CREATE TABLE messages (
    id                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    contenu              TEXT         NOT NULL,
    date_envoi           DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id_expediteur   INT UNSIGNED NOT NULL,
    user_id_destinataire INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    KEY idx_messages_expediteur (user_id_expediteur),
    KEY idx_messages_destinataire (user_id_destinataire),
    CONSTRAINT fk_messages_expediteur FOREIGN KEY (user_id_expediteur)
        REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_messages_destinataire FOREIGN KEY (user_id_destinataire)
        REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Jeu de données
-- ============================================================

-- Mot de passe : TomTroc2026! (haché avec password_hash)
INSERT INTO users (id, prenom, email, password, photo, created_at) VALUES
(1, 'Nathalire',   'nathalie@tomtroc.fr', '$2y$10$qmExAMBjinKhJXaDZEKoLOPOywz9LDV43TI2mCXjf1c/ckkaX4vPu', NULL, '2025-03-12 10:00:00'),
(2, 'Alexlecture', 'alex@tomtroc.fr',     '$2y$10$qmExAMBjinKhJXaDZEKoLOPOywz9LDV43TI2mCXjf1c/ckkaX4vPu', NULL, '2025-09-02 18:30:00'),
(3, 'Sas634',      'sas@tomtroc.fr',      '$2y$10$qmExAMBjinKhJXaDZEKoLOPOywz9LDV43TI2mCXjf1c/ckkaX4vPu', NULL, '2026-01-20 09:15:00');

-- Les images référencées sont présentes dans public/img/.
-- Une image NULL affiche l'image par défaut (default-book.png).
INSERT INTO books (id, user_id, titre, auteur, image, description, disponible) VALUES
(1, 1, 'The Kinfolk Table', 'Nathan Williams', 'kinfolk.png',
 'Un très beau livre de recettes qui met à l''honneur les repas simples partagés entre amis.\n\nLes photographies sont magnifiques et chaque recette est accompagnée du portrait de la personne qui la propose. Je l''ai beaucoup utilisé, il est en très bon état.',
 1),
(2, 1, 'Wabi Sabi', 'Beth Kempton', 'wabi-sabi.png',
 'Une introduction accessible à la philosophie japonaise du wabi-sabi : accepter l''imperfection et apprécier les choses simples.\n\nUne lecture apaisante, idéale pour ralentir un peu.',
 1),
(3, 1, 'Milk & Honey', 'Rupi Kaur', 'milk-honey.png',
 'Recueil de poèmes courts sur l''amour, la perte et la reconstruction. Se lit d''une traite mais se relit avec plaisir.',
 0),
(4, 2, 'Esther', 'Alabaster', 'esther.png',
 'Une édition illustrée très soignée, avec de grandes photographies sur chaque double page. Un bel objet à feuilleter.',
 1),
(5, 2, 'Le Petit Prince', 'Antoine de Saint-Exupéry', NULL,
 'Le grand classique, dans une édition de poche un peu usée mais complète. Parfait pour le relire ou le faire découvrir.',
 1),
(6, 2, 'L''Étranger', 'Albert Camus', NULL,
 'Roman court et marquant. Quelques passages soulignés au crayon, sinon en bon état.',
 0),
(7, 3, 'Les Misérables', 'Victor Hugo', NULL,
 'Édition intégrale en deux volumes. Une longue lecture, mais l''une des plus belles de la littérature française.\n\nJe préfère l''échanger contre un roman contemporain.',
 1),
(8, 3, 'Sapiens', 'Yuval Noah Harari', NULL,
 'Une histoire de l''humanité racontée de manière très claire. Couverture légèrement abîmée.',
 1);

INSERT INTO messages (contenu, date_envoi, user_id_expediteur, user_id_destinataire) VALUES
('Bonjour Nathalire ! Votre livre The Kinfolk Table est-il toujours disponible ?', '2026-10-10 15:40:00', 2, 1),
('Bonjour ! Oui, il est toujours disponible. Qu''aimeriez-vous proposer en échange ?', '2026-10-10 15:44:00', 1, 2),
('J''ai Esther et Le Petit Prince dans ma bibliothèque, l''un des deux vous intéresse ?', '2026-10-10 15:48:00', 2, 1),
('Esther me plairait beaucoup. On peut se retrouver samedi ?', '2026-10-10 16:02:00', 1, 2),
('Bonjour, je suis intéressé par Wabi Sabi. Seriez-vous d''accord pour un échange ?', '2026-10-12 09:20:00', 3, 1),
('Bonjour Sas634, avec plaisir ! Je regarde votre bibliothèque et je reviens vers vous.', '2026-10-12 10:05:00', 1, 3);