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
}