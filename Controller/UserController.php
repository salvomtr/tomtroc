<?php
namespace App\Controller;

use App\Core\Route;

class UserController extends AbstractController {

    #[Route('/user')]
    public function index(): void {
        $this->render('test', ['title' => 'User' . $id]);
    }

    #[Route('/user/:id')]
    public function show(int $id): void {
        $this->render('test', ['title' => 'User avec id: ' . $id]);
    }
}
