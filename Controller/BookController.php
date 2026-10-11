<?php
namespace App\Controller;

use App\Core\Route;

class BookController extends AbstractController {
    

    #[Route('/livres')]
    public function index(): void {
        
        $bookModel = new \App\Model\BookModel();

        $search =$_GET['search'] ?? '';

        if($search) {
            $livres = $bookModel->search($search);
        } else {
            $livres = $bookModel->findAllWithUser();
        }

        $this->render('book/index', [
            'livres' => $livres,
            'search' => $search
        ]);
    }

    #[Route('/livres/:id')]
    public function show(int $id): void {
        $bookModel = new \App\Model\BookModel();
        $livre = $bookModel->findByIdWithUser($id);

        $this->render('book/show', [
            'livre' => $livre,
            'metaTitle' => $livre['titre'],
            'user' => $this->getUser(),
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
            $this->redirect('/mon-compte');
        } else {
            $this->render('book/add');
        }
    }

    // Recupere un livre et verifie qu'il appartient a l'utilisateur connecté
    private function getLivreDuProprietaire(int $id): array {
        $bookModel = new \App\Model\BookModel();
        $livre = $bookModel->findById($id);
        $user = $this->getUser();

        if (!$livre || $livre['user_id'] != $user['id']) {
            $this->redirect('/mon-compte');
        }

        return $livre;
    }

    #[Route('/livre/supprimer/:id')]
    public function delete(int $id): void {
        // L'utilisateur doit etre connecté
        $this->requireLogin();

        //Verifie que le livre existe et appartient a l'utilisateur
        $this->getLivreDuProprietaire($id);

        //Supprime le livre
        $bookModel = new \App\Model\BookModel();
        $bookModel->delete($id);

        //Retour sur Mon Compte
        $this->redirect('/mon-compte');
    }
}

