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

        // Si le livre n'existe pas, retour à la liste
        if (!$livre) {
            $this->redirect('/livres');
        }

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
                'image' => $this->uploadImage(),
                'user_id' => $user['id'],
            ]);
            $this->redirect('/mon-compte');
        } else {
            $this->render('book/add');
        }
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

    #[Route('/livre/editer/:id')]
    public function edit(int $id): void {
        // 1. Connecté + propriétaire du livre
        $this->requireLogin();
        $livre = $this->getLivreDuProprietaire($id);

        // 2. Formulaire envoyé : on sauvegarde
        if ($this->isPost()) {
            $data = [
                'titre'       => $_POST['titre'],
                'auteur'      => $_POST['auteur'],
                'description' => $_POST['description'],
                'disponible'  => isset($_POST['disponible']) ? 1 : 0,
            ];

            // Nouvelle image seulement si l'utilisateur en a choisi une
            $image = $this->uploadImage();
            if ($image) {
                $data['image'] = $image;
            }

            $bookModel = new \App\Model\BookModel();
            $bookModel->update($id, $data);
            $this->redirect('/mon-compte');
        }

        // 3. Sinon : formulaire pré-rempli
        $this->render('book/edit', [
            'livre' => $livre,
        ]);
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

    // Enregistre l'image envoyée et retourne son nom, ou null si aucune image valide
    private function uploadImage(): ?string {
        // 1. Aucun fichier envoyé
        if (empty($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $fichier = $_FILES['image'];

        // 2. Erreur pendant l'envoi
        if ($fichier['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // 3. Taille maximum : 2 Mo
        if ($fichier['size'] > 2 * 1024 * 1024) {
            return null;
        }

        // 4. Vérifie le vrai type du fichier (son contenu, pas son nom)
        $typesAutorises = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $type = mime_content_type($fichier['tmp_name']);

        if (!isset($typesAutorises[$type])) {
            return null;
        }

        // 5. Nom unique, avec l'extension correspondant au type vérifié
        $nom = uniqid('livre_') . '.' . $typesAutorises[$type];

        // 6. Déplace le fichier dans public/img/
        move_uploaded_file($fichier['tmp_name'], __DIR__ . '/../public/img/' . $nom);

        return $nom;
    }
}
