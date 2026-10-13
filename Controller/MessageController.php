<?php
namespace App\Controller;

use App\Core\Route;

class MessageController extends AbstractController {

    #[Route('/messages')]
    public function index(): void {
        $this->requireLogin();
        $user = $this->getUser();
        $messageModel = new \App\Model\MessageModel();
        $conversations = $messageModel->getConversations($user['id']);

        // Ouvre directement la conversation la plus récente
        if (!empty($conversations)) {
            $this->redirect('/messages/' . $conversations[0]['id']);
        }

        // Aucune conversation : messagerie vide
        $this->render('message/show', [
            'conversations'       => [],
            'messages'            => [],
            'user'                => $user,
            'conversationOuverte' => false,
        ]);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $this->requireLogin();
        $user = $this->getUser();
        $messageModel = new \App\Model\MessageModel();

        // Formulaire envoyé : on enregistre le message (s'il n'est pas vide)
        if ($this->isPost() && trim($_POST['contenu'] ?? '') !== '') {
            $messageModel->create([
                'contenu'              => trim($_POST['contenu']),
                'date_envoi'           => date('Y-m-d H:i:s'),
                'user_id_expediteur'   => $user['id'],
                'user_id_destinataire' => $id,
            ]);

            $this->redirect('/messages/' . $id);
        }

        $conversations = $messageModel->getConversations($user['id']);
        $messages = $messageModel->findConversation($user['id'], $id);

        $this->render('message/show', [
            'conversations'       => $conversations,
            'messages'            => $messages,
            'user'                => $user,
            'conversationOuverte' => true,
        ]);
    }
}