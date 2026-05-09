<?php
session_start();

// Autoload de clases
spl_autoload_register(function ($class_name) {
    $paths = [
        'controllers/' . $class_name . '.php',
        'models/' . $class_name . '.php',
        'config/' . $class_name . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Incluir configuración
require_once 'config/config.php';

// Obtener la URL
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Determinar controlador y método
$controllerName = isset($url[0]) && !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$methodName = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Verificar si existe el controlador
if (file_exists('controllers/' . $controllerName . '.php')) {
    $controller = new $controllerName();
    
    // Verificar si existe el método
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        // Método no encontrado
        header("HTTP/1.0 404 Not Found");
        require_once 'views/errors/404.php';
    }
} else {
    // Controlador no encontrado
    header("HTTP/1.0 404 Not Found");
    require_once 'views/errors/404.php';
}
