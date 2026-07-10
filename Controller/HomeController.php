<?php
namespace App\Controller;

use App\Core\Route;

class HomeController {

    #[Route('/')]
    public function index(): void {
        echo "Homepage de TomTroc";
    }

}