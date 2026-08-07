<?php
namespace App\Controller;

use App\Core\Route;

class UserController extends AbstractController {

    #[Route('/user')]
    public function index(): void {
        $this->render('test', ['title' => 'User']);
    }

    #[Route('/user/:id')]
    public function show(int $id): void {
        $this->render('test', ['title' => 'User avec id: ' . $id]);
    }

    #[Route('/inscription')]
    public function register(): void {
        if($this->isPost()) {
            // Recupere les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $date_naissance = $_POST['date_naissance'];

            //Sauvegarde dans la bdd
            $userModel = new \App\Model\UserModel();
            $userModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => $password,
                'date_naissance' => $date_naissance,
            ]);

            $this->redirect("/tomtroc/connexion");

        } else {
            $this->render('user/register');
        }
    } 
    
    #[Route('/connexion')]
    public function login(): void {
        if($this->isPost()) {
            // Recupere les donnees du formulaire
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Cherche l'utilisateur par mail dans la bdd
            $userModel = new \App\Model\UserModel();
            $user = $userModel->findByEmail($email);

            // Verifie si l'utilisateur existe et si le mot de passe est correct
            if($user && password_verify($password, $user['password'])) {
                // Stocke l'utilisateur en session
                $_SESSION['user'] = $user;
                //Redirige vers la page d'accueil
                $this->redirect('/tomtroc/');
            } else {
                //Affiche le formulaire avec un message d'erreur
                $this->render('user/login', ['error' => 'Email ou mot de passe incorrect']);
            }
        } else {
            // Affiche le formulaire de connexion
            $this->render('user/login');

        }
    }
}
