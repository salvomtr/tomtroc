<?php
require_once 'config/autoload.php';
require_once '.env.php';
require_once 'config/database.php';

session_start();

use App\Core\Router;

$router = new Router();
$router->scanControllers(__DIR__ . '/Controller/');
$router->run();


