<?php
namespace App\Core;

use Attribute;

//Declare que cette classe est un attribut php 8
// Elle sera utilisée pour définir les routes directement sur les méthodes des controllers
#[Attribute(Attribute::TARGET_METHOD)]
class Route {

    // Constructeur qui accepte le chemin de la route 
    // ex: #[Route('/')] ou #[Route('/livres')]
    public function __construct(
        public string $path // Le chemin de l'url ex: '/livres', '/livres/:id'
    ) {}
}