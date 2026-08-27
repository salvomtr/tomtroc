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

        $this->render('book/show', [
            'livre' => $livre,
            'metaTitle' => $livre['titre'], 
            ]);
    }

    #[Route('/livre/ajouter')]
    public function add(): void {
        $this->requireLogin();
        
        if($this->isPost()) {
            $user = $this->getUser();
            $bookModel = new \App\Model\BookModel();
            $bookModel->create([
                'titre' => $_POST['titre'],
                'auteur' => $_POST['auteur'],
                'description' => $_POST['description'],
                'disponible' => isset($_POST['disponible']) ? 1 : 0,
                'user_id' => $user['id'],
            ]);
            $this->redirect('/tomtroc/mon-compte');
        } else {
            $this->render('book/add');
        }
    }

}

