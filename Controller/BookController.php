<?php
namespace App\Controller;

use App\Core\Route;
use App\Entity\Book;
use App\Manager\BookManager;

class BookController extends AbstractController {

    // Dossier où sont enregistrées les images des livres
    private const DOSSIER_IMAGES = __DIR__ . '/../public/img/';

    #[Route('/livres')]
    public function index(): void {
        $bookManager = new BookManager();

        // Mot recherché dans l'URL, ex. /livres?search=wabi
        $search = trim($_GET['search'] ?? '');

        if ($search) {
            $livres = $bookManager->search($search);
        } else {
            $livres = $bookManager->findAllWithUser();
        }

        $this->render('book/index', [
            'livres' => $livres,
            'search' => $search,
        ]);
    }

    #[Route('/livres/:id')]
    public function show(int $id): void {
        $bookManager = new BookManager();
        $livre = $bookManager->findByIdWithUser($id);

        // Le livre n'existe pas : page 404
        if (!$livre) {
            $this->notFound();
        }

        $this->render('book/show', [
            'livre'     => $livre,
            'metaTitle' => $livre->getTitre(),
            'user'      => $this->getUser(),
        ]);
    }

    #[Route('/livre/ajouter')]
    public function add(): void {
        $this->requireLogin();

        if ($this->isPost()) {
            // 1. Données du formulaire, nettoyées
            $data = $this->donneesFormulaire();

            // 2. Vérifications côté serveur
            $error = $this->validerLivre($data) ?? $this->validerImage();

            // 3. Une erreur : on réaffiche le formulaire avec la saisie
            if ($error) {
                $this->render('book/add', [
                    'livre' => new Book($data),
                    'error' => $error,
                ]);
                return;
            }

            // 4. Tout est bon : enregistrement
            $data['image']   = $this->uploadImage();
            $data['user_id'] = $this->getUser()->getId();

            $bookManager = new BookManager();
            $bookManager->create($data);
            $this->redirect('/mon-compte');
        }

        $this->render('book/add', [
            'livre' => new Book(),
        ]);
    }

    #[Route('/livre/supprimer/:id')]
    public function delete(int $id): void {
        // L'utilisateur doit être connecté
        $this->requireLogin();

        // La suppression ne se fait qu'avec un formulaire POST (jamais avec un simple lien)
        if (!$this->isPost()) {
            $this->redirect('/mon-compte');
        }

        // Vérifie que le livre existe et appartient à l'utilisateur
        $livre = $this->getLivreDuProprietaire($id);

        // Supprime le livre, puis son image sur le disque
        $bookManager = new BookManager();
        $bookManager->delete($id);
        $this->supprimerImage($livre->getImage());

        // Retour sur Mon compte
        $this->redirect('/mon-compte');
    }

    #[Route('/livre/editer/:id')]
    public function edit(int $id): void {
        // 1. Connecté et propriétaire du livre
        $this->requireLogin();
        $livre = $this->getLivreDuProprietaire($id);

        // 2. Formulaire envoyé : on vérifie puis on enregistre
        if ($this->isPost()) {
            $data = $this->donneesFormulaire();
            $error = $this->validerLivre($data) ?? $this->validerImage();

            // Une erreur : on réaffiche le formulaire avec la saisie
            if ($error) {
                $livre->hydrate($data);
                $this->render('book/edit', [
                    'livre' => $livre,
                    'error' => $error,
                ]);
                return;
            }

            // Nouvelle image : on l'enregistre et on supprime l'ancienne du disque
            $image = $this->uploadImage();
            if ($image) {
                $data['image'] = $image;
                $this->supprimerImage($livre->getImage());
            }

            $bookManager = new BookManager();
            $bookManager->update($id, $data);
            $this->redirect('/mon-compte');
        }

        // 3. Sinon : formulaire pré-rempli
        $this->render('book/edit', [
            'livre' => $livre,
        ]);
    }

    // Récupère un livre et vérifie qu'il appartient à l'utilisateur connecté
    private function getLivreDuProprietaire(int $id): Book {
        $bookManager = new BookManager();
        $livre = $bookManager->findById($id);

        // Le livre n'existe pas : page 404
        if (!$livre) {
            $this->notFound();
        }

        // Le livre appartient à un autre utilisateur : retour à Mon compte
        if ($livre->getUserId() !== $this->getUser()->getId()) {
            $this->redirect('/mon-compte');
        }

        return $livre;
    }

    // Récupère les champs du formulaire livre, sans espaces autour
    private function donneesFormulaire(): array {
        return [
            'titre'       => trim($_POST['titre'] ?? ''),
            'auteur'      => trim($_POST['auteur'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'disponible'  => ($_POST['disponible'] ?? '1') === '1' ? 1 : 0,
        ];
    }

    // Vérifie les champs du livre : retourne un message d'erreur, ou null si tout est bon
    private function validerLivre(array $data): ?string {
        if ($data['titre'] === '' || $data['auteur'] === '') {
            return "Le titre et l'auteur sont obligatoires.";
        }
        // Les colonnes titre et auteur font 255 caractères maximum en base
        if (mb_strlen($data['titre']) > 255 || mb_strlen($data['auteur']) > 255) {
            return "Le titre et l'auteur ne doivent pas dépasser 255 caractères.";
        }
        if (mb_strlen($data['description']) > 5000) {
            return 'Le commentaire ne doit pas dépasser 5000 caractères.';
        }
        return null;
    }

    // Vérifie l'image envoyée : retourne un message d'erreur, ou null si tout est bon
    // (pas d'image envoyée = pas d'erreur, la photo est facultative)
    private function validerImage(): ?string {
        if (empty($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $fichier = $_FILES['image'];

        if ($fichier['error'] !== UPLOAD_ERR_OK || $fichier['size'] > 2 * 1024 * 1024) {
            return "L'image ne doit pas dépasser 2 Mo.";
        }
        if (!$this->extensionImage($fichier['tmp_name'])) {
            return "L'image doit être au format JPG, PNG ou WEBP.";
        }
        return null;
    }

    // Retourne l'extension correspondant au vrai type du fichier (son contenu, pas son nom)
    private function extensionImage(string $chemin): ?string {
        $typesAutorises = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];

        return $typesAutorises[mime_content_type($chemin)] ?? null;
    }

    // Enregistre l'image envoyée (déjà validée) et retourne son nom, ou null si aucune image
    private function uploadImage(): ?string {
        if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fichier = $_FILES['image'];

        // Nom unique, avec l'extension correspondant au type vérifié
        $nom = uniqid('livre_') . '.' . $this->extensionImage($fichier['tmp_name']);

        // Déplace le fichier dans public/img/
        move_uploaded_file($fichier['tmp_name'], self::DOSSIER_IMAGES . $nom);

        return $nom;
    }

    // Supprime physiquement une image de livre du disque
    // Seules les images envoyées par les utilisateurs (nom commençant par "livre_")
    // sont supprimées : les images du jeu de données et l'image par défaut sont conservées
    private function supprimerImage(?string $nom): void {
        if (!$nom || !str_starts_with($nom, 'livre_')) {
            return;
        }

        // basename() empêche de sortir du dossier (ex. "../../index.php")
        $chemin = self::DOSSIER_IMAGES . basename($nom);

        if (is_file($chemin)) {
            unlink($chemin);
        }
    }
}