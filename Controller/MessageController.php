<?php
namespace App\Controller;

use App\Core\Route;

class MessageController extends AbstractController {

    #[Route('/messages')]
    public function index(): void {
        $this->render('test', ['title' => 'Message']);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $this->render('test', ['title' => 'Message avec id: ' . $id]);
    }
}