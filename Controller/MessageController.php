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

        // Conversation la plus récente (null s'il n'y en a aucune)
        $interlocuteurId = $conversations[0]['id'] ?? null;
        $messages = $interlocuteurId ? $messageModel->findConversation($user['id'], $interlocuteurId) : [];
        $interlocuteur = $interlocuteurId ? (new \App\Model\UserModel())->findById($interlocuteurId) : null;

        // Vue "liste" : sur mobile, seule la liste des conversations est affichée
        $this->render('message/show', [
            'conversations'   => $conversations,
            'messages'        => $messages,
            'user'            => $user,
            'interlocuteurId' => $interlocuteurId,
            'interlocuteur'   => $interlocuteur,
            'vue'             => 'liste',
        ]);
    }

    #[Route('/messages/:id')]
    public function show(int $id): void {
        $this->requireLogin();
        $user = $this->getUser();

        // L'interlocuteur doit exister et ne pas être soi-même
        $interlocuteur = (new \App\Model\UserModel())->findById($id);
        if (!$interlocuteur || $id === $user['id']) {
            $this->redirect('/messages');
        }

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

        // Vue "conversation" : sur mobile, seul le fil de discussion est affiché
        $this->render('message/show', [
            'conversations'   => $conversations,
            'messages'        => $messages,
            'user'            => $user,
            'interlocuteurId' => $id,
            'interlocuteur'   => $interlocuteur,
            'vue'             => 'conversation',
        ]);
    }
}