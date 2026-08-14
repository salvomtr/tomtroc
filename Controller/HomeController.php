<?php
namespace App\Controller;

use App\Core\Route;

class HomeController extends AbstractController {

    #[Route('/')]
    public function index(): void {
        $this->render('home/index');
    }
}