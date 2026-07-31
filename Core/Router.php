<?php
namespace App\Core;

class Router {
    
    // Tableau associatif qui stocke toutes les routes de l'application
    // Format : ['url' => [ControllerClass, 'methode']]
    private array $routes = [];

    // Méthode qui permet d'ajouter une route au tableau
    // $url : le chemin de l'url ex: '/livres'
    // $action : le callable ex: [BookController::class, 'index']
    public function add(string $url, array $action): void { 
        $this->routes[$url] = $action;
    }


    // Scanne les controlleurs et lit les attributs #[Route]
    // pour construire automatiquement le tableau des routes
    public function scan(array $controllers): void {
        foreach($controllers as $controller) {
            //Crée un objet ReflectionClass pour inspecter le controller
            $reflection = new \ReflectionClass($controller);

            //Recupere tous les methods du controller
            foreach($reflection->getMethods() as $method) {
                // Lit les attributs #[Route] sur chaque methode
                $attributes = $method->getAttributes(Route::class);

                foreach($attributes as $attribute) {
                    //Cree une instance de Route pour recuperer le path
                    $route = $attribute->newInstance();

                    // Ajoute la route au tableau
                    $this->add($route->path, [$controller, $method->getName()]);
                }
            }
        }
    }

    // Scanne automatiquement le dossier Controller/ pour trouver tous les controllers
    public function scanControllers(string $path): void {
        //Recupere tous les fichers du dossier
        $files = scandir($path);

        $controllers = [];

        foreach($files as $file) {
            //Ignore . .. et AbstractController
            if($file === '.' || $file === '..' || $file === 'AbstractController.php') {
                continue;
            }

            //Convertit 'HomeController.php' -> 'App\Controller\HomeController'
            $class = 'App\\Controller\\' . str_replace('.php', '', $file);

            $controllers[] = $class;
        }

        // Utilise le methode scan() existante
        $this->scan($controllers);
    }

    public function run(): void {
       $url = $_SERVER['REQUEST_URI'];
       $url = str_replace('/tomtroc', '', $url);

       //Boucle sur toutes les routes
       foreach($this->routes as $route => $action) {
            // Convertit :id en regex ([0-9]+)
            $pattern = preg_replace('/:([a-zA-Z]+)/', '([0-9]+)',  $route);
            $pattern = '#^' . $pattern . '$#';

            // Veerifie si l'url correspond au pattern
            if(preg_match($pattern, $url, $matches)) {
                [$class, $method] = $action;
                $controller = new $class();

                //Supprime le premier element (url complete)
                array_shift($matches);

                //Appelle la methode avec les parametres
                $controller->$method(...$matches);
                return;
            }
       }

       echo "404 - Page non trouvée";
    }
}
