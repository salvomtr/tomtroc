<?php
namespace App\Controller;

use App\Core\Route;

class BookController {

    #[Route('/livres')]
    public function index(): void {
        echo "Book";
    }

    #[Route('/livres/:id')]
    public function show(int $id): void {
        echo "Livre avec id: " . $id;
    }
}