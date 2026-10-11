<?php
namespace App\Controller;

use App\Core\Route;

class MessageController extends AbstractController {

   #[Route('/messages')]
    public function index(): void {
        $this->requireLogin();
        $user = $this->getUser();
        $messageModel = new \App\Model\MessageModel();
        $messages = $messageModel->getConversations($user['id']);
        
        $this->render('message/index', [
            'messages' => $messages
        ]);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $this->requireLogin();
        $user = $this->getUser();
        $messageModel = new \App\Model\MessageModel();

        $conversations = $messageModel->getConversations($user['id']);
        $messages = $messageModel->findConversation($user['id'], $id);

        $this->render('message/show', [
            'conversations' => $conversations,
            'messages'      => $messages,
            'user'          => $user,
        ]);
    }
}