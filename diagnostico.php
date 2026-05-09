<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico</title>
</head>
<body>
    <h1>Estado del Sistema</h1>
    <ul>
        <li>PHP Version: <?php echo phpversion(); ?></li>
        <li>Server: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
        <li>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
        <li>Request URI: <?php echo $_SERVER['REQUEST_URI']; ?></li>
        <li>Script Name: <?php echo $_SERVER['SCRIPT_NAME']; ?></li>
    </ul>
    
    <h2>Test de Configuración</h2>
    <p>BASE_URL: <?php define('BASE_URL', '/cursosonline/'); echo BASE_URL; ?></p>
    
    <h2>Enlaces de Prueba</h2>
    <ul>
        <li><a href="/cursosonline/">Home (con htaccess)</a></li>
        <li><a href="/cursosonline/index.php">index.php directo</a></li>
        <li><a href="/cursosonline/home/index">Home Controller</a></li>
        <li><a href="/cursosonline/auth/login">Login</a></li>
    </ul>
</body>
</html>
