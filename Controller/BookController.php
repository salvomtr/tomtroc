<?php
namespace App\Controller;

use App\Core\Route;

class BookController extends AbstractController {
    

    #[Route('/livres')]
    public function index(): void {
        $bookModel = new \App\Model\BookModel();
        $livres = $bookModel->findAll();

        $this->render('book/index', ['livres' => $livres]);
    }

    #[Route('/livres/:id')]
    public function show(int $id): void {
        $bookModel = new \App\Model\BookModel();
        $livre = $bookModel->findById($id);

        $this->render('book/show', ['livre' => $livre]);
    }

}

