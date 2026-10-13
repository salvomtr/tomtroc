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

        if ($this->isPost()) {
            // 1. Les données toujours mises à jour
            $data = [
                'prenom' => $_POST['pseudo'],
                'email'  => $_POST['email'],
            ];

            // 2. Le mot de passe seulement s'il a été rempli
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // 3. Sauvegarde dans la base
            $userModel = new \App\Model\UserModel();
            $userModel->update($user['id'], $data);

            // 4. Met à jour la session avec les nouvelles données
            $userAJour = $userModel->findById($user['id']);
            unset($userAJour['password']);
            $_SESSION['user'] = $userAJour;

            // 5. Retour sur la page
            $this->redirect('/mon-compte');
        }

        $bookModel = new \App\Model\BookModel();
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