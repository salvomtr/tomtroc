<?php
require_once 'config/autoload.php';
session_start();

use App\Controller\BookController;
use App\Controller\HomeController;
use App\Controller\MessageController;
use App\Controller\UserController;
use App\Core\Router;

$router = new Router();

// Scanne automatiquement les controllers pour trouver les routes
$router->scan([
    HomeController::class,
    BookController::class,
    MessageController::class,
    UserController::class,
]);

$router->run();

