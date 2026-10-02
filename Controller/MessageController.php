<?php
namespace App\Controller;

use App\Core\Route;

class MessageController extends AbstractController {

    #[Route('/messages')]
    public function index(): void {
        $this->requireLogin();
        $messageModel = new \App\Model\MessageModel();
        $messages = $messageModel->findAll();
        
        $this->render('message/index', [
            'messages' => $messages
        ]);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $this->requireLogin();
        $messageModel = new \App\Model\MessageModel();
        $message = $messageModel->findById($id);
        
        $this->render('message/show', [
            'message' => $message
        ]);
    }
}