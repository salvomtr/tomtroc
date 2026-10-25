<?php
namespace App\Manager;

use App\Entity\Message;

class MessageManager extends AbstractManager {

    protected string $table = 'messages';
    protected string $entity = Message::class;

    // Les conversations de l'utilisateur : une ligne par interlocuteur,
    // avec le contenu et la date du dernier message échangé
    public function getConversations(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT
                u.id     AS interlocuteur_id,
                u.prenom AS interlocuteur_prenom,
                u.photo  AS interlocuteur_photo,
                MAX(m.date_envoi) AS date_envoi,
                (SELECT m2.contenu
                 FROM messages m2
                 WHERE (m2.user_id_expediteur = u.id AND m2.user_id_destinataire = :id4)
                    OR (m2.user_id_expediteur = :id5 AND m2.user_id_destinataire = u.id)
                 ORDER BY m2.date_envoi DESC, m2.id DESC
                 LIMIT 1) AS contenu
            FROM messages m
            JOIN users u ON u.id = CASE
                    WHEN m.user_id_expediteur = :id1 THEN m.user_id_destinataire
                    ELSE m.user_id_expediteur
                END
            WHERE m.user_id_expediteur = :id2
               OR m.user_id_destinataire = :id3
            GROUP BY u.id, u.prenom, u.photo
            ORDER BY date_envoi DESC
        ");

        // Avec PDO, chaque paramètre nommé ne peut être utilisé qu'une fois
        $stmt->execute([
            'id1' => $userId,
            'id2' => $userId,
            'id3' => $userId,
            'id4' => $userId,
            'id5' => $userId,
        ]);

        return $this->hydrateAll($stmt->fetchAll());
    }

    // Le fil de discussion entre deux utilisateurs, du plus ancien au plus récent
    public function findConversation(int $userId, int $interlocuteurId): array {
        $stmt = $this->pdo->prepare("
            SELECT id, contenu, date_envoi, user_id_expediteur, user_id_destinataire
            FROM messages
            WHERE (user_id_expediteur = :id1 AND user_id_destinataire = :id2)
               OR (user_id_expediteur = :id3 AND user_id_destinataire = :id4)
            ORDER BY date_envoi ASC, id ASC
        ");

        $stmt->execute([
            'id1' => $userId,
            'id2' => $interlocuteurId,
            'id3' => $interlocuteurId,
            'id4' => $userId,
        ]);

        return $this->hydrateAll($stmt->fetchAll());
    }
}