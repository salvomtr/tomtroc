<?php
namespace App\Entity;

class Book extends AbstractEntity {

    private ?int $id = null;
    private int $userId = 0;
    private string $titre = '';
    private string $auteur = '';
    private ?string $image = null;
    private ?string $description = null;
    private bool $disponible = true;

    // Informations du propriétaire, remplies par une jointure SQL
    // (alias proprietaire_prenom et proprietaire_photo dans les requêtes)
    private ?string $proprietairePrenom = null;
    private ?string $proprietairePhoto = null;

    // --- Getters ---

    public function getId(): ?int {
        return $this->id;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    // Description raccourcie pour les tableaux, ex. 80 caractères puis "…"
    public function getDescriptionCourte(int $longueur = 80): string {
        $description = $this->description ?? '';

        if (mb_strlen($description) <= $longueur) {
            return $description;
        }
        return mb_substr($description, 0, $longueur) . '…';
    }

    public function isDisponible(): bool {
        return $this->disponible;
    }

    public function getProprietairePrenom(): ?string {
        return $this->proprietairePrenom;
    }

    public function getProprietairePhoto(): ?string {
        return $this->proprietairePhoto;
    }

    // --- Setters ---

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }

    public function setImage(?string $image): void {
        $this->image = $image;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setDisponible(bool $disponible): void {
        $this->disponible = $disponible;
    }

    public function setProprietairePrenom(?string $prenom): void {
        $this->proprietairePrenom = $prenom;
    }

    public function setProprietairePhoto(?string $photo): void {
        $this->proprietairePhoto = $photo;
    }
}