<?php
require_once 'config/autoload.php';
session_start();

use App\Core\Router;
use App\Core\Route;

$router = new Router();

// Scanne automatiquement les controllers pour trouver les routes
/*$router->scan([
    HomeController::class,
    BookController::class,
    MessageController::class,
    UserController::class,
]);*/

$router->scanControllers(__DIR__ . '/Controller/');
$router->run();


