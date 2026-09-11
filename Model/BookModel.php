<?php
namespace App\Model;

class BookModel extends AbstractModel {

    protected string $table = 'books';

    public function findByUserId(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findLastBooks(int $limit): array {
        $stmt= $this->pdo->prepare(
            "SELECT * FROM books ORDER BY id DESC LIMIT ?"
        );
        //$stmt = $this->pdo->prepare(
        //"SELECT * FROM books ORDER BY id DESC LIMIT " . (int)$limit);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}