<?php
namespace App\Core;

class Router {

    // Tableau associatif qui stocke toutes les routes de l'application
    // Format : ['url' => [ControllerClass, 'méthode']]
    private array $routes = [];

    // Ajoute une route au tableau
    // $url : le chemin de l'URL, ex. '/livres'
    // $action : le contrôleur et la méthode, ex. [BookController::class, 'index']
    public function add(string $url, array $action): void {
        $this->routes[$url] = $action;
    }

    // Lit les attributs #[Route] des contrôleurs
    // pour construire automatiquement le tableau des routes
    public function scan(array $controllers): void {
        foreach ($controllers as $controller) {
            // Crée un objet ReflectionClass pour inspecter le contrôleur
            $reflection = new \ReflectionClass($controller);

            // Récupère toutes les méthodes du contrôleur
            foreach ($reflection->getMethods() as $method) {
                // Lit les attributs #[Route] de chaque méthode
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    // Crée une instance de Route pour récupérer le chemin
                    $route = $attribute->newInstance();

                    // Ajoute la route au tableau
                    $this->add($route->path, [$controller, $method->getName()]);
                }
            }
        }
    }

    // Parcourt le dossier Controller/ pour trouver tous les contrôleurs
    public function scanControllers(string $path): void {
        // Récupère tous les fichiers du dossier
        $files = scandir($path);

        $controllers = [];

        foreach ($files as $file) {
            // Ignore . et .. ainsi qu'AbstractController (classe abstraite, sans route)
            if ($file === '.' || $file === '..' || $file === 'AbstractController.php') {
                continue;
            }

            // Convertit 'HomeController.php' en 'App\Controller\HomeController'
            $class = 'App\\Controller\\' . str_replace('.php', '', $file);

            $controllers[] = $class;
        }

        // Utilise la méthode scan() pour lire les routes
        $this->scan($controllers);
    }

    // Cherche la route qui correspond à l'URL et appelle la bonne méthode
    public function run(): void {
        $url = $_SERVER['REQUEST_URI'];
        $url = strtok($url, '?'); // Supprime les paramètres GET, ex. ?search=...

        // Parcourt toutes les routes
        foreach ($this->routes as $route => $action) {
            // Convertit :id en expression régulière ([0-9]+)
            $pattern = preg_replace('/:([a-zA-Z]+)/', '([0-9]+)', $route);
            // ^ et $ : l'URL entière doit correspondre
            $pattern = '#^' . $pattern . '$#';

            // Vérifie si l'URL correspond à la route
            if (preg_match($pattern, $url, $matches)) {
                [$class, $method] = $action;
                $controller = new $class();

                // Supprime le premier élément (l'URL complète)
                array_shift($matches);

                // Appelle la méthode avec les paramètres, ex. show(5)
                $controller->$method(...$matches);
                return;
            }
        }

        // Aucune route ne correspond : page 404 avec le layout et le code HTTP 404
        $controller = new \App\Controller\ErrorController();
        $controller->notFound();
    }
}