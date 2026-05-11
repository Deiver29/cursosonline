<?php
/**
 * Script para convertir URLs de YouTube/Vimeo existentes al formato embed
 * Ejecuta esto UNA VEZ para arreglar lecciones antiguas
 */

require_once 'config/config.php';
require_once 'config/Database.php';

function convertirURLVideo($url) {
    // YouTube
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
    
    // Vimeo
    if (preg_match('/(?:vimeo\.com\/(?:video\/)?|player\.vimeo\.com\/video\/)(\d+)/', $url, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[1];
    }
    
    return $url;
}

$db = Database::getInstance()->getConnection();

// Obtener todas las lecciones con URLs de YouTube/Vimeo
$sql = "SELECT id, titulo, url_contenido FROM lecciones 
        WHERE url_contenido LIKE '%youtube.com%' 
           OR url_contenido LIKE '%youtu.be%' 
           OR url_contenido LIKE '%vimeo.com%'";
$stmt = $db->query($sql);
$lecciones = $stmt->fetchAll();

$actualizadas = 0;

foreach ($lecciones as $leccion) {
    $url_original = $leccion['url_contenido'];
    $url_convertida = convertirURLVideo($url_original);
    
    if ($url_original !== $url_convertida) {
        $update = "UPDATE lecciones SET url_contenido = :url WHERE id = :id";
        $stmt = $db->prepare($update);
        $stmt->bindParam(':url', $url_convertida);
        $stmt->bindParam(':id', $leccion['id']);
        $stmt->execute();
        $actualizadas++;
    }
}

// También actualizar los tipos de contenido vacíos
$sql2 = "UPDATE lecciones SET tipo_contenido = 'video' 
         WHERE (tipo_contenido IS NULL OR tipo_contenido = '') 
         AND (url_contenido LIKE '%youtube%' OR url_contenido LIKE '%vimeo%')";
$stmt2 = $db->prepare($sql2);
$stmt2->execute();
$tipos_actualizados = $stmt2->rowCount();

?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>URLs de Video Convertidas</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 700px;
            margin: 100px auto;
            padding: 20px;
            background: #F8FAFC;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success {
            color: #059669;
            font-size: 48px;
            margin-bottom: 20px;
        }
        h1 {
            color: #6D28D9;
            margin-bottom: 10px;
        }
        .stats {
            background: #F3F4F6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #6D28D9;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        a:hover {
            background: #5B21B6;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='success'>✅</div>
        <h1>URLs de Video Actualizadas</h1>
        
        <div class='stats'>
            <p><strong>URLs convertidas al formato embed:</strong> <?php echo $actualizadas; ?></p>
            <p><strong>Tipos de contenido actualizados:</strong> <?php echo $tipos_actualizados; ?></p>
        </div>
        
        <p style='color: #6B7280;'>
            Los videos de YouTube y Vimeo ahora funcionarán correctamente en la plataforma.
        </p>
        
        <a href='<?php echo BASE_URL; ?>aprendiz/verCurso/1'>Ver Curso</a>
        
        <p style='margin-top: 30px; font-size: 0.875rem; color: #9CA3AF;'>
            ⚠️ Puedes eliminar este archivo (convertir_urls_video.php) después de ejecutarlo.
        </p>
    </div>
</body>
</html>
