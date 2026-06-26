<?php
spl_autoload_register(function($class) {
    // $class: App\Core\Router
    $class = str_replace('App\\', '', $class);
    // $class: Core\Router
    $class = str_replace('\\', '/', $class);
    // $class: Core/Router
    $file = $class . '.php';
    // $file: Core/Router.php
    require_once __DIR__ . '/../' . $file; 
});




