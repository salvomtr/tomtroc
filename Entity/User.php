<?php
namespace App\Entity;

class User extends AbstractEntity {

    private ?int $id = null;
    private string $prenom = '';
    private string $email = '';
    private string $password = '';
    private ?string $photo = null;
    private ?string $createdAt = null;

    // --- Getters ---

    public function getId(): ?int {
        return $this->id;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPhoto(): ?string {
        return $this->photo;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    // Photo à afficher : celle de l'utilisateur ou l'image par défaut
    public function getPhotoOuDefaut(): string {
        return $this->photo ?: 'img_profil.jpg';
    }

    // Ancienneté du membre, ex. "1 an", "3 mois", "5 jours"
    public function getAnciennete(): string {
        if (!$this->createdAt) {
            return "moins d'un jour";
        }

        $duree = (new \DateTime($this->createdAt))->diff(new \DateTime());

        if ($duree->y > 0) {
            return $duree->y . ' an' . ($duree->y > 1 ? 's' : '');
        }
        if ($duree->m > 0) {
            return $duree->m . ' mois';
        }
        if ($duree->d > 0) {
            return $duree->d . ' jour' . ($duree->d > 1 ? 's' : '');
        }
        return "moins d'un jour";
    }

    // --- Setters ---

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setPhoto(?string $photo): void {
        $this->photo = $photo;
    }

    public function setCreatedAt(?string $createdAt): void {
        $this->createdAt = $createdAt;
    }
}