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
        $stmt = $this->pdo->prepare(
            "SELECT books.*, users.prenom 
            FROM books 
            JOIN users ON books.user_id = users.id 
            ORDER BY books.id DESC LIMIT ?"
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findAllWithUser(): array {
        $stmt = $this->pdo->query(
            "SELECT books.*, users.nom, users.prenom 
            FROM books 
            JOIN users ON books.user_id = users.id
            ORDER BY books.id DESC"
        );
        return $stmt->fetchAll();
    }

    public function search(string $search): array {
        $stmt = $this->pdo->prepare(
            "SELECT books.*, users.nom, users.prenom 
            FROM books 
            JOIN users ON books.user_id = users.id
            WHERE books.titre LIKE ?
            ORDER BY books.id DESC"
        );
        $stmt->execute(['%' . $search . '%']);
        return $stmt->fetchAll();
    }

    public function findByIdWithUser(int $id): array|false {
        $stmt = $this->pdo->prepare(
            "SELECT books.*, users.nom, users.prenom 
            FROM books 
            JOIN users ON books.user_id = users.id
            WHERE books.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
}