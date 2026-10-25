<?php
namespace App\Controller;

use App\Core\Route;
use App\Manager\BookManager;
use App\Manager\UserManager;

class UserController extends AbstractController {

    #[Route('/user/:id')]
    public function show(int $id): void {
        $userManager = new UserManager();
        $profil = $userManager->findById($id);

        // L'utilisateur n'existe pas : page 404
        if (!$profil) {
            $this->notFound();
        }

        // Bibliothèque de l'utilisateur
        $bookManager = new BookManager();
        $livres = $bookManager->findByUserId($id);

        $this->render('user/profile', [
            'profil' => $profil,
            'livres' => $livres,
            'user'   => $this->getUser(),
        ]);
    }

    #[Route('/inscription')]
    public function register(): void {
        if ($this->isPost()) {
            // Récupère les données du formulaire, sans espaces autour
            $prenom = trim($_POST['prenom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userManager = new UserManager();
            $error = null;

            // Vérifications
            if ($prenom === '' || $email === '' || $password === '') {
                $error = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse email n'est pas valide.";
            } elseif ($userManager->findByEmail($email)) {
                $error = 'Cette adresse email est déjà utilisée.';
            }

            // Une erreur : on réaffiche le formulaire avec le message
            if ($error) {
                $this->render('user/register', [
                    'error'  => $error,
                    'prenom' => $prenom,
                    'email'  => $email,
                ]);
                return;
            }

            // Tout est bon : enregistrement dans la base
            $userManager->create([
                'prenom'   => $prenom,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            $this->redirect('/connexion');
        } else {
            $this->render('user/register');
        }
    }

    #[Route('/connexion')]
    public function login(): void {
        if ($this->isPost()) {
            // Récupère les données du formulaire
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Cherche l'utilisateur par email dans la base
            $userManager = new UserManager();
            $user = $userManager->findByEmail($email);

            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($password, $user->getPassword())) {
                // Nouvel identifiant de session : protège contre la fixation de session
                session_regenerate_id(true);

                // On ne garde en session que l'id de l'utilisateur
                $_SESSION['user_id'] = $user->getId();

                $this->redirect('/');
            } else {
                // Réaffiche le formulaire avec un message d'erreur
                $this->render('user/login', ['error' => 'Email ou mot de passe incorrect']);
            }
        } else {
            // Affiche le formulaire de connexion
            $this->render('user/login');
        }
    }

    #[Route('/mon-compte')]
    public function monCompte(): void {
        $this->requireLogin();
        $user = $this->getUser();
        $bookManager = new BookManager();

        if ($this->isPost()) {
            // 1. Récupère les données sans espaces autour
            $prenom = trim($_POST['pseudo'] ?? '');
            $email  = trim($_POST['email'] ?? '');

            $userManager = new UserManager();
            $error = null;

            // 2. Vérifications (les mêmes qu'à l'inscription)
            $existant = $userManager->findByEmail($email);

            if ($prenom === '' || $email === '') {
                $error = "Le pseudo et l'adresse email sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse email n'est pas valide.";
            } elseif ($existant && $existant->getId() !== $user->getId()) {
                // L'email appartient à un AUTRE utilisateur
                $error = 'Cette adresse email est déjà utilisée.';
            }

            // 3. Une erreur : on réaffiche la page avec le message et la saisie
            if ($error) {
                $user->setPrenom($prenom);
                $user->setEmail($email);

                $this->render('user/account', [
                    'user'   => $user,
                    'livres' => $bookManager->findByUserId($user->getId()),
                    'error'  => $error,
                ]);
                return;
            }

            // 4. Les données valides
            $data = [
                'prenom' => $prenom,
                'email'  => $email,
            ];

            // 5. Le mot de passe seulement s'il a été rempli
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // 6. Enregistrement, puis retour sur la page
            $userManager->update($user->getId(), $data);
            $this->redirect('/mon-compte');
        }

        $this->render('user/account', [
            'user'   => $user,
            'livres' => $bookManager->findByUserId($user->getId()),
        ]);
    }

    #[Route('/deconnexion')]
    public function logout(): void {
        session_destroy();
        $this->redirect('/');
    }
}