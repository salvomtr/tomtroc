<?php
namespace App\Model;

class UserModel extends AbstractModel {
    protected string $table = 'users';

    //Trouve un utilisateur par son email
    public function findByEmail(string $email): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}