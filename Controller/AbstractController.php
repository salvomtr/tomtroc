<?php
namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;

abstract class AbstractController {

    // Utilisateur connecté, chargé une seule fois par requête
    private ?User $utilisateurConnecte = null;

    // Affiche une vue à l'intérieur du layout commun
    protected function render(string $view, array $data = []): void {
        // Transforme le tableau en variables, ex. ['livre' => $x] devient $livre
        extract($data);

        // Chemin de la vue, ex. 'book/show' devient '../views/book/show.php'
        $path = __DIR__ . '/../views/' . $view . '.php';

        // Capture le HTML de la vue dans $content
        ob_start();
        require $path;
        $content = ob_get_clean();

        // Affiche le layout, qui contient $content
        require __DIR__ . '/../views/layout.php';
    }

    // Vérifie si la requête est en POST (formulaire envoyé)
    // Un formulaire POST n'est accepté que s'il contient le bon jeton CSRF
    protected function isPost(): bool {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $this->verifierCsrf();
        return true;
    }

    // Protection CSRF : le jeton envoyé doit être identique à celui de la session
    // Un autre site ne connaît pas ce jeton, il ne peut donc pas envoyer
    // un formulaire à la place de l'utilisateur
    private function verifierCsrf(): void {
        $jeton = $_POST['csrf_token'] ?? '';

        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $jeton)) {
            http_response_code(403);
            $this->render('error/403', ['metaTitle' => 'Requête refusée']);
            exit;
        }
    }

    // Redirige vers une autre URL et arrête le script
    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    // Redirige vers la connexion si l'utilisateur n'est pas connecté
    protected function requireLogin(): void {
        if (!$this->isLogged()) {
            $this->redirect('/connexion');
        }
    }

    // Vérifie si l'utilisateur est connecté
    protected function isLogged(): bool {
        return $this->getUser() !== null;
    }

    // Récupère l'utilisateur connecté (objet User), ou null
    // La session ne contient que son id : les données viennent toujours de la base
    protected function getUser(): ?User {
        if ($this->utilisateurConnecte === null && isset($_SESSION['user_id'])) {
            $this->utilisateurConnecte = (new UserManager())->findById($_SESSION['user_id']);
        }
        return $this->utilisateurConnecte;
    }

    // Affiche la page 404 avec le layout et le bon code HTTP
    public function notFound(): void {
        http_response_code(404);
        $this->render('error/404', ['metaTitle' => 'Page introuvable']);
        exit;
    }
}