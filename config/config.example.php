<?php
// ============================================
// PLANTILLA DE CONFIGURACIÓN
// ============================================
// Copia este archivo a config.php y ajusta los valores
// ============================================

// Configuración general del sistema
define('BASE_URL', 'http://localhost:8080/cursosonline/');
define('SITE_NAME', 'Marketplace Educativo');

// Configuración de base de datos
define('DB_HOST', 'localhost');          // Host de MySQL (normalmente localhost)
define('DB_NAME', 'marketplace');        // Nombre de tu base de datos
define('DB_USER', 'root');               // Usuario de MySQL
define('DB_PASS', '');                   // Contraseña de MySQL (vacío en XAMPP por defecto)

// Configuración de rutas
define('ROOT_PATH', dirname(__DIR__) . '/');
define('UPLOAD_PATH', ROOT_PATH . 'uploads/');

// Configuración de idiomas soportados
define('LANGUAGES', ['es', 'en', 'fr', 'pt', 'de']);

// Configuración de monedas
define('CURRENCIES', ['USD', 'EUR', 'GBP', 'MXN', 'ARS', 'COP']);

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Manejo de errores
// En desarrollo: E_ALL y display_errors = 1
// En producción: 0 y display_errors = 0
error_reporting(E_ALL);
ini_set('display_errors', 1);
