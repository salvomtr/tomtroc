<?php
require_once 'config/autoload.php';
session_start();

use App\Controller\BookController;
use App\Controller\HomeController;
use App\Controller\MessageController;
use App\Controller\UserController;
use App\Core\Router;

$router = new Router();

$routes = [
    '/' => [HomeController::class, 'index'],
    '/livres' => [BookController::class, 'index'],
    '/messages' => [MessageController::class, 'index'],
    '/user' => [UserController::class, 'index'],
];

foreach($routes as $url => $action) {
    $router->add($url, $action);
}

$router->run();

