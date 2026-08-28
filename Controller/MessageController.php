<?php
namespace App\Controller;

use App\Core\Route;

class MessageController extends AbstractController {

    public function __construct()
    {
        $this->requireLogin();
    }

    #[Route('/messages')]
    public function index(): void {
        $messageModel = new \App\Model\MessageModel();
        $messages = $messageModel->findAll();
        
        $this->render('message/index', [
            'messages' => $messages
        ]);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $messageModel = new \App\Model\MessageModel();
        $message = $messageModel->findById($id);
        
        $this->render('message/show', [
            'message' => $message
        ]);
    }

}