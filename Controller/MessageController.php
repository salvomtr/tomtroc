<?php
namespace App\Controller;

use App\Core\Route;
use App\Manager\MessageManager;
use App\Manager\UserManager;

class MessageController extends AbstractController {

    #[Route('/messages')]
    public function index(): void {
        $this->requireLogin();
        $user = $this->getUser();
        $messageManager = new MessageManager();
        $conversations = $messageManager->getConversations($user->getId());

        // Conversation la plus récente (null s'il n'y en a aucune)
        $interlocuteurId = isset($conversations[0]) ? $conversations[0]->getInterlocuteurId() : null;
        $messages = $interlocuteurId ? $messageManager->findConversation($user->getId(), $interlocuteurId) : [];
        $interlocuteur = $interlocuteurId ? (new UserManager())->findById($interlocuteurId) : null;

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

        $interlocuteur = (new UserManager())->findById($id);

        // L'interlocuteur n'existe pas : page 404
        if (!$interlocuteur) {
            $this->notFound();
        }

        // On ne peut pas s'écrire à soi-même : retour à la messagerie
        if ($id === $user->getId()) {
            $this->redirect('/messages');
        }

        $messageManager = new MessageManager();

        // Formulaire envoyé : on enregistre le message (s'il n'est pas vide)
        if ($this->isPost() && trim($_POST['contenu'] ?? '') !== '') {
            $messageManager->create([
                'contenu'              => trim($_POST['contenu']),
                'date_envoi'           => date('Y-m-d H:i:s'),
                'user_id_expediteur'   => $user->getId(),
                'user_id_destinataire' => $id,
            ]);

            $this->redirect('/messages/' . $id);
        }

        // Vue "conversation" : sur mobile, seul le fil de discussion est affiché
        $this->render('message/show', [
            'conversations'   => $messageManager->getConversations($user->getId()),
            'messages'        => $messageManager->findConversation($user->getId(), $id),
            'user'            => $user,
            'interlocuteurId' => $id,
            'interlocuteur'   => $interlocuteur,
            'vue'             => 'conversation',
        ]);
    }
}