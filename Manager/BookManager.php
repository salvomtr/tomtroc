<?php
namespace App\Manager;

use App\Entity\Book;
use PDO;

class BookManager extends AbstractManager {

    protected string $table = 'books';
    protected string $entity = Book::class;

    // Colonnes communes : le livre + le prénom et la photo de son propriétaire
    private const SELECT_AVEC_PROPRIETAIRE =
        "SELECT books.*,
                users.prenom AS proprietaire_prenom,
                users.photo AS proprietaire_photo
         FROM books
         JOIN users ON books.user_id = users.id";

    // Tous les livres d'un utilisateur (disponibles ou non)
    public function findByUserId(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $this->hydrateAll($stmt->fetchAll());
    }

    // Les derniers livres disponibles, pour l'accueil
    public function findLastBooks(int $limit): array {
        $stmt = $this->pdo->prepare(
            self::SELECT_AVEC_PROPRIETAIRE . "
             WHERE books.disponible = 1
             ORDER BY books.id DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $this->hydrateAll($stmt->fetchAll());
    }

    // Tous les livres disponibles, pour la page Nos livres
    public function findAllWithUser(): array {
        $stmt = $this->pdo->query(
            self::SELECT_AVEC_PROPRIETAIRE . "
             WHERE books.disponible = 1
             ORDER BY books.id DESC"
        );
        return $this->hydrateAll($stmt->fetchAll());
    }

    // Recherche par titre parmi les livres disponibles
    public function search(string $search): array {
        $stmt = $this->pdo->prepare(
            self::SELECT_AVEC_PROPRIETAIRE . "
             WHERE books.titre LIKE ?
             AND books.disponible = 1
             ORDER BY books.id DESC"
        );
        $stmt->execute(['%' . $search . '%']);
        return $this->hydrateAll($stmt->fetchAll());
    }

    // Un livre avec son propriétaire, ou null s'il n'existe pas
    public function findByIdWithUser(int $id): ?Book {
        $stmt = $this->pdo->prepare(self::SELECT_AVEC_PROPRIETAIRE . " WHERE books.id = ?");
        $stmt->execute([$id]);
        return $this->hydrate($stmt->fetch());
    }
}