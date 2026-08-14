<?php
namespace App\Model;

class BookModel extends AbstractModel {

    protected string $table = 'books';

    public function findByUserId(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}