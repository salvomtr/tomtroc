<?php
namespace App\Controller;

use App\Core\Route;

class UserController extends AbstractController {

    #[Route('/user/:id')]
    public function show(int $id): void {
        $userModel = new \App\Model\UserModel();
        $profil = $userModel->findById($id);

        // Si l'utilisateur n'existe pas, retour à la liste des livres
        if (!$profil) {
            $this->redirect('/livres');
        }

        // Bibliothèque de l'utilisateur
        $bookModel = new \App\Model\BookModel();
        $livres = $bookModel->findByUserId($id);

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

            $userModel = new \App\Model\UserModel();
            $error = null;

            // Vérifications
            if ($prenom === '' || $email === '' || $password === '') {
                $error = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse email n'est pas valide.";
            } elseif ($userModel->findByEmail($email)) {
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

            // Tout est bon : sauvegarde dans la base
            $userModel->create([
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
            $userModel = new \App\Model\UserModel();
            $user = $userModel->findByEmail($email);

            // Vérifie si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']);
                // Stocke l'utilisateur en session
                $_SESSION['user'] = $user;
                // Redirige vers la page d'accueil
                $this->redirect('/');
            } else {
                // Affiche le formulaire avec un message d'erreur
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
        $bookModel = new \App\Model\BookModel();

        if ($this->isPost()) {
            // 1. Récupère les données sans espaces autour
            $prenom = trim($_POST['pseudo'] ?? '');
            $email  = trim($_POST['email'] ?? '');

            $userModel = new \App\Model\UserModel();
            $error = null;

            // 2. Vérifications (les mêmes qu'à l'inscription)
            $existant = $userModel->findByEmail($email);

            if ($prenom === '' || $email === '') {
                $error = "Le pseudo et l'adresse email sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "L'adresse email n'est pas valide.";
            } elseif ($existant && $existant['id'] != $user['id']) {
                // L'email appartient à un AUTRE utilisateur
                $error = 'Cette adresse email est déjà utilisée.';
            }

            // 3. Une erreur : on réaffiche la page avec le message
            if ($error) {
                $this->render('user/account', [
                    'user'   => array_merge($user, ['prenom' => $prenom, 'email' => $email]),
                    'livres' => $bookModel->findByUserId($user['id']),
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

            // 6. Sauvegarde dans la base
            $userModel->update($user['id'], $data);

            // 7. Met à jour la session avec les nouvelles données
            $userAJour = $userModel->findById($user['id']);
            unset($userAJour['password']);
            $_SESSION['user'] = $userAJour;

            // 8. Retour sur la page
            $this->redirect('/mon-compte');
        }

        $livres = $bookModel->findByUserId($user['id']);

        $this->render('user/account', [
            'user'   => $user,
            'livres' => $livres,
        ]);
    }

    #[Route('/deconnexion')]
    public function logout(): void {
        session_destroy();
        $this->redirect('/');
    }
}