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
        // Récupère l'url de la requête courante
        // $_SERVER['REQUEST_URI'] contient le chemin de l'url ex: /tomtroc/livres
        $url = $_SERVER['REQUEST_URI'];
        
        // Supprime '/tomtroc' de l'url pour travailler avec des chemins propres
        // ex: /tomtroc/livres → /livres
        $url = str_replace('/tomtroc', '', $url);
        
        // Vérifie si la route existe dans le tableau
        if(isset($this->routes[$url])) {
            
            // Déstructure le tableau [$class, $method]
            // ex: [HomeController::class, 'index'] → $class = 'App\Controller\HomeController', $method = 'index'
            [$class, $method] = $this->routes[$url];
            
            // Crée une instance du controller dynamiquement
            $controller = new $class();
            
            // Appelle la méthode du controller dynamiquement
            $controller->$method();
            
        } else {
            // Aucune route trouvée → page 404
            echo "404 - Page non trouvée";
        }
    }
}







/*
<?php
namespace App\Core; // Namespace della classe - organizza il codice ed evita conflitti di nomi

class Router { // Dichiarazione della classe Router
    
    public function run(): void { // Metodo pubblico run() - chiamato da index.php con $router->run()
        
        // Recupera l'URL della richiesta corrente
        // $_SERVER è una variabile superglobale PHP
        // REQUEST_URI contiene il percorso dell'URL ex: /tomtroc/livres
        $url = $_SERVER['REQUEST_URI'];
        
        // Rimuove '/tomtroc' dall'URL per lavorare con percorsi puliti
        // str_replace('cosa cercare', 'cosa sostituire', 'dove cercare')
        // Ex: /tomtroc/livres → /livres
        $url = str_replace('/tomtroc', '', $url);
      
        // Switch controlla il valore di $url e cerca il case corrispondente
        // Equivalente a tanti if/elseif ma più leggibile
        switch($url) {
            
            case '/': // Se $url vale '/'
                $controller = new \App\Controller\HomeController(); // Crea un oggetto HomeController
                $controller->index(); // Chiama il metodo index()
                break; // Esce dal switch - senza break PHP continuerebbe gli altri case
            
            case '/livres': // Se $url vale '/livres'
                $controller = new \App\Controller\BookController(); // Crea un oggetto BookController
                $controller->index(); // Chiama il metodo index()
                break;
            
            case '/messages': // Se $url vale '/messages'
                $controller = new \App\Controller\MessageController(); // Crea un oggetto MessageController
                $controller->index(); // Chiama il metodo index()
                break;
            
            case '/user': // Se $url vale '/user'
                $controller = new \App\Controller\UserController(); // Crea un oggetto UserController
                $controller->index(); // Chiama il metodo index()
                break; 
            
            default: // Eseguito quando nessun case corrisponde → pagina 404
                echo "404 - Page non trouvée";
                break;                
        }
    }
}

*/


