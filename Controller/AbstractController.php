<?php
namespace App\Controller;

abstract class AbstractController {

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
    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
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
        return isset($_SESSION['user']);
    }

    // Récupère l'utilisateur connecté
    protected function getUser(): array|null {
        return $_SESSION['user'] ?? null;
    }

    // Affiche la page 404 avec le layout et le bon code HTTP
    public function notFound(): void {
        http_response_code(404);
        $this->render('error/404', ['metaTitle' => 'Page introuvable']);
        exit;
    }
}