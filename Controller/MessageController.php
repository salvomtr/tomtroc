<?php
namespace App\Controller;

use App\Core\Route;

class MessageController {

    #[Route('/messages')]
    public function index(): void {
        echo "Message";
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        echo "Message avec id: " . $id;
    }
}