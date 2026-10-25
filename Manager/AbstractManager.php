<?php
namespace App\Manager;

use PDO;

abstract class AbstractManager {

    // Connexion à la base de données
    protected PDO $pdo;

    // Nom de la table gérée par le manager, ex. 'books'
    protected string $table;

    // Classe de l'entité à créer pour chaque ligne, ex. Book::class
    protected string $entity;

    public function __construct() {
        $this->pdo = getDB();
    }

    // Transforme une ligne SQL en objet entité (hydratation)
    protected function hydrate(array|false $ligne): ?object {
        if (!$ligne) {
            return null;
        }
        return new $this->entity($ligne);
    }

    // Transforme plusieurs lignes SQL en tableau d'objets
    protected function hydrateAll(array $lignes): array {
        return array_map(fn(array $ligne) => new $this->entity($ligne), $lignes);
    }

    // Récupère tous les enregistrements de la table
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $this->hydrateAll($stmt->fetchAll());
    }

    // Récupère un enregistrement par son id, ou null s'il n'existe pas
    public function findById(int $id): ?object {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $this->hydrate($stmt->fetch());
    }

    // Insère un nouvel enregistrement
    // Les noms de colonnes viennent toujours du code (jamais de $_POST) ;
    // les valeurs passent par des paramètres préparés.
    public function create(array $data): bool {
        $colonnes = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} ($colonnes) VALUES ($placeholders)"
        );

        return $stmt->execute(array_values($data));
    }

    // Met à jour un enregistrement existant
    public function update(int $id, array $data): bool {
        // Construit "titre = ?, auteur = ?" à partir des clés du tableau
        $set = implode(', ', array_map(fn($colonne) => "$colonne = ?", array_keys($data)));

        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = ?");

        // Les valeurs du SET, puis l'id pour le WHERE
        $valeurs = array_values($data);
        $valeurs[] = $id;

        return $stmt->execute($valeurs);
    }

    // Supprime un enregistrement par son id
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}