<?php
namespace App\Controller;

abstract class AbstractController {

    protected function render(string $view, array $data = []): void {
        // Extrait les variables du tableau $data, ex: ['titre' => 'TomTroc'] -> $titre = 'TomTroc'
        extract($data);

        //Construit le chemin vers le fichier de vue, ex: 'home/index' -> '../view/home/index.php'
        $path = __DIR__ . '/../views/' . $view . '.php';

        //Inclut le fichier de vue
        require $path;

    }
}