<?php
namespace App\Model;

use PDO;

abstract class AbstractModel {

    // Connexion a la bdd
    protected PDO $pdo;

    // Nom de la table associée au model
    protected string $table;

    public function __construct()
    {
        $this->pdo = getDB();
    }

    // REcupere tous les enregistrement de la table
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    // Recupere un enregistrement par son id
    public function findById(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    //Insere un nouvel enregistrement dans la table
    public function create(array $data): bool {   //TODO verificare rischio injection sql
        //Recupere les noms des colonnes 
        $colonnes = implode(', ', array_keys($data));

        // Crée les placeholders ?, ?, ?
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} ($colonnes) VALUES ($placeholders)"
        );

        return $stmt->execute(array_values($data));
    }

    // Met à jour un enregistrement existant
    public function update(int $id, array $data): bool {
        // Construit "prenom = ?, email = ?" à partir des clés du tableau
        $set = implode(', ', array_map(fn($colonne) => "$colonne = ?", array_keys($data)));

        $stmt = $this->pdo->prepare(
        "UPDATE {$this->table} SET $set WHERE id = ?"
        );

        // Les valeurs du SET, puis l'id pour le WHERE
        $valeurs = array_values($data);
        $valeurs[] = $id;

        return $stmt->execute($valeurs);
    }
}