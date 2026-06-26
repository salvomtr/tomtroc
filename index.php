<?php
require_once 'config/autoload.php';
session_start();

use App\Controller\TestController;
use App\Core\Router;

$router = new Router();
$router->run();

