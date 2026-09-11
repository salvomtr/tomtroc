<?php
namespace App\Controller;

use App\Core\Route;

class HomeController extends AbstractController {

    #[Route('/')]
    public function index(): void {
        $bookModel = new \App\Model\BookModel();
        $derniers_livres = $bookModel->findLastBooks(4);

        $this->render('home/index',[
            'derniers_livres' => $derniers_livres
        ]);
    }
}