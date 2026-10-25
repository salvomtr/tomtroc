<?php
namespace App\Entity;

class Message extends AbstractEntity {

    private ?int $id = null;
    private string $contenu = '';
    private string $dateEnvoi = '';
    private int $userIdExpediteur = 0;
    private int $userIdDestinataire = 0;

    // Informations de l'interlocuteur, utilisées pour la liste des conversations
    // (alias interlocuteur_id, interlocuteur_prenom et interlocuteur_photo)
    private ?int $interlocuteurId = null;
    private ?string $interlocuteurPrenom = null;
    private ?string $interlocuteurPhoto = null;

    // --- Getters ---

    public function getId(): ?int {
        return $this->id;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function getDateEnvoi(): string {
        return $this->dateEnvoi;
    }

    public function getUserIdExpediteur(): int {
        return $this->userIdExpediteur;
    }

    public function getUserIdDestinataire(): int {
        return $this->userIdDestinataire;
    }

    public function getInterlocuteurId(): ?int {
        return $this->interlocuteurId;
    }

    public function getInterlocuteurPrenom(): ?string {
        return $this->interlocuteurPrenom;
    }

    public function getInterlocuteurPhoto(): ?string {
        return $this->interlocuteurPhoto;
    }

    // Vrai si le message a été envoyé par cet utilisateur
    public function estEnvoyePar(int $userId): bool {
        return $this->userIdExpediteur === $userId;
    }

    // --- Setters ---

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setContenu(string $contenu): void {
        $this->contenu = $contenu;
    }

    public function setDateEnvoi(string $dateEnvoi): void {
        $this->dateEnvoi = $dateEnvoi;
    }

    public function setUserIdExpediteur(int $userId): void {
        $this->userIdExpediteur = $userId;
    }

    public function setUserIdDestinataire(int $userId): void {
        $this->userIdDestinataire = $userId;
    }

    public function setInterlocuteurId(?int $id): void {
        $this->interlocuteurId = $id;
    }

    public function setInterlocuteurPrenom(?string $prenom): void {
        $this->interlocuteurPrenom = $prenom;
    }

    public function setInterlocuteurPhoto(?string $photo): void {
        $this->interlocuteurPhoto = $photo;
    }
}