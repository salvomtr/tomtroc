<?php
namespace App\Manager;

use App\Entity\User;

class UserManager extends AbstractManager {

    protected string $table = 'users';
    protected string $entity = User::class;

    // Trouve un utilisateur par son email, ou null s'il n'existe pas
    public function findByEmail(string $email): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $this->hydrate($stmt->fetch());
    }
}