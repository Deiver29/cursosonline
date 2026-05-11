<?php
require_once 'config/config.php';
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();
$sql = "SELECT l.id, l.titulo, l.tipo_contenido, l.url_contenido, l.contenido, m.titulo as modulo 
        FROM lecciones l 
        INNER JOIN modulos m ON l.modulo_id = m.id 
        WHERE m.curso_id = 1 
        LIMIT 10";
$stmt = $db->query($sql);
$lecciones = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Debug Lecciones</title>
    <style>
        body { font-family: monospace; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #6D28D9; color: white; }
        .url { max-width: 300px; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>
    <h1>Debug: Lecciones del Curso 1</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Módulo</th>
            <th>Título</th>
            <th>Tipo</th>
            <th>URL/Archivo</th>
            <th>Contenido Texto</th>
        </tr>
        <?php foreach($lecciones as $l): ?>
        <tr>
            <td><?= $l['id'] ?></td>
            <td><?= $l['modulo'] ?></td>
            <td><?= $l['titulo'] ?></td>
            <td><strong><?= $l['tipo_contenido'] ?></strong></td>
            <td class="url"><?= $l['url_contenido'] ?: '(vacío)' ?></td>
            <td><?= substr($l['contenido'], 0, 50) ?: '(vacío)' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
