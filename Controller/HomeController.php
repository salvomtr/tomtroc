<?php
namespace App\Controller;

use App\Core\Route;
use App\Manager\BookManager;

class HomeController extends AbstractController {

    #[Route('/')]
    public function index(): void {
        $bookManager = new BookManager();
        $derniersLivres = $bookManager->findLastBooks(4);

        $this->render('home/index', [
            'derniers_livres' => $derniersLivres,
        ]);
    }
}