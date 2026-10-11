<?php
namespace App\Model;

use PDO;

class MessageModel extends AbstractModel {

    protected string $table = 'messages';

    // Récupère toutes les conversations de l'utilisateur
    public function getConversations(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT
                u.id,
                u.prenom,
                u.photo,
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

        $stmt->execute([
            'id1' => $userId,
            'id2' => $userId,
            'id3' => $userId,
            'id4' => $userId,
            'id5' => $userId,
        ]);

        return $stmt->fetchAll();
    }

    public function findConversation(int $userId, int $user_id_expediteur): array {
        $stmt = $this->pdo->prepare("
            SELECT id, contenu, date_envoi, user_id_expediteur, user_id_destinataire
            FROM messages
            WHERE (user_id_expediteur = :id1 AND user_id_destinataire = :id2)
            OR (user_id_expediteur = :id3 AND user_id_destinataire = :id4)
            ORDER BY date_envoi ASC
        ");

        $stmt->execute([
            'id1' => $userId,
            'id2' => $user_id_expediteur,
            'id3' => $user_id_expediteur,
            'id4' => $userId,
        ]);

        return $stmt->fetchAll();
    }
}