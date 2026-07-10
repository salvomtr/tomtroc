<?php
namespace App\Controller;

use App\Core\Route;

class UserController {

    #[Route('/user')]
    public function index(): void {
        echo "User";
    }

    #[Route('/user/:id')]
    public function show(int $id): void {
        echo "Utilisateur avec id: " . $id;
    }
}