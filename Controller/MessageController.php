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

        if ($this->isPost()){

        $messageModel->create([
                'contenu'              => $_POST['contenu'],
                'date_envoi'           => date('Y-m-d H:i:s'),
                'user_id_expediteur'   => $user['id'],
                'user_id_destinataire' => $id,
            ]);

            $this->redirect('/messages/' . $id);

        };

        $conversations = $messageModel->getConversations($user['id']);
        $messages = $messageModel->findConversation($user['id'], $id);


        $this->render('message/show', [
            'conversations' => $conversations,
            'messages'      => $messages,
            'user'          => $user,
        ]);
    }
}