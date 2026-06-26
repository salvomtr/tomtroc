<?php
namespace App\Core;

class Router {
    public function run() {
        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/tomtroc', '', $url);
      
        switch($url) {
            case '/':
                $controller = new \App\Controller\HomeController();
                $controller->index();
                break;
            case '/livres':
                $controller = new \App\Controller\BookController();
                $controller->index();
                break;
            case '/messages':
                $controller = new \App\Controller\MessageController();
                $controller->index();
                break;
            case '/user':
                $controller = new \App\Controller\UserController();
                $controller->index();
                break; 
            default:
                echo "404 - Page non trouvée";
                break;                
        }
    }
}


