<?php
namespace App\Controller;

use App\Core\Route;

class BookController extends AbstractController {
    

    #[Route('/livres')]
    public function index(): void {
        $this->render('test', ['title' => 'page d\'accueil']);
    }

    #[Route('/livres/:id')]
    public function show(int $id): void {
        echo "Livre avec id: " . $id;
    }

}

