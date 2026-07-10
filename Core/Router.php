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
