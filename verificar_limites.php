<?php
/**
 * Verificador de Límites de PHP
 * Muestra la configuración actual de subida de archivos
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Límites PHP - Learnly</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #F8FAFC;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h1 {
            color: #6D28D9;
            margin-bottom: 10px;
        }
        .config-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .config-table th,
        .config-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        .config-table th {
            background: #F3F4F6;
            font-weight: 600;
        }
        .status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status.ok {
            background: #D1FAE5;
            color: #065F46;
        }
        .status.warning {
            background: #FEF3C7;
            color: #92400E;
        }
        .status.error {
            background: #FEE2E2;
            color: #991B1B;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .alert-info {
            background: #EFF6FF;
            color: #1E40AF;
            border-left: 4px solid #2563EB;
        }
        .alert-warning {
            background: #FEF3C7;
            color: #92400E;
            border-left: 4px solid #F59E0B;
        }
        code {
            background: #F3F4F6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Configuración Actual de PHP</h1>
        <p>Verifica los límites de subida de archivos configurados en tu servidor.</p>

        <?php
        $upload_max = ini_get('upload_max_filesize');
        $post_max = ini_get('post_max_size');
        $max_execution = ini_get('max_execution_time');
        $max_input_time = ini_get('max_input_time');
        $memory_limit = ini_get('memory_limit');

        // Convertir a bytes para comparar
        function convertToBytes($value) {
            $value = trim($value);
            $unit = strtolower($value[strlen($value)-1]);
            $value = (int)$value;
            
            switch($unit) {
                case 'g': $value *= 1024;
                case 'm': $value *= 1024;
                case 'k': $value *= 1024;
            }
            return $value;
        }

        $upload_bytes = convertToBytes($upload_max);
        $post_bytes = convertToBytes($post_max);
        
        // Determinar estado
        $upload_status = 'error';
        $upload_msg = 'Muy bajo';
        if ($upload_bytes >= 524288000) { // >= 500MB
            $upload_status = 'ok';
            $upload_msg = 'Excelente';
        } elseif ($upload_bytes >= 104857600) { // >= 100MB
            $upload_status = 'warning';
            $upload_msg = 'Suficiente';
        }

        $post_status = ($post_bytes > $upload_bytes) ? 'ok' : 'error';
        $post_msg = ($post_bytes > $upload_bytes) ? 'Correcto' : '¡Debe ser mayor que upload_max_filesize!';

        $time_status = 'error';
        $time_msg = 'Muy corto';
        if ($max_execution >= 600) {
            $time_status = 'ok';
            $time_msg = 'Excelente';
        } elseif ($max_execution >= 300) {
            $time_status = 'warning';
            $time_msg = 'Suficiente';
        }
        ?>

        <table class="config-table">
            <thead>
                <tr>
                    <th>Parámetro</th>
                    <th>Valor Actual</th>
                    <th>Estado</th>
                    <th>Recomendado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>upload_max_filesize</strong><br><small>Tamaño máximo por archivo</small></td>
                    <td><code><?php echo $upload_max; ?></code></td>
                    <td><span class="status <?php echo $upload_status; ?>"><?php echo $upload_msg; ?></span></td>
                    <td><code>500M</code></td>
                </tr>
                <tr>
                    <td><strong>post_max_size</strong><br><small>Tamaño total de datos POST</small></td>
                    <td><code><?php echo $post_max; ?></code></td>
                    <td><span class="status <?php echo $post_status; ?>"><?php echo $post_msg; ?></span></td>
                    <td><code>550M</code></td>
                </tr>
                <tr>
                    <td><strong>max_execution_time</strong><br><small>Tiempo máximo de ejecución</small></td>
                    <td><code><?php echo $max_execution; ?> segundos</code></td>
                    <td><span class="status <?php echo $time_status; ?>"><?php echo $time_msg; ?></span></td>
                    <td><code>600</code> (10 min)</td>
                </tr>
                <tr>
                    <td><strong>max_input_time</strong><br><small>Tiempo máximo de entrada</small></td>
                    <td><code><?php echo $max_input_time; ?> segundos</code></td>
                    <td>-</td>
                    <td><code>600</code></td>
                </tr>
                <tr>
                    <td><strong>memory_limit</strong><br><small>Límite de memoria</small></td>
                    <td><code><?php echo $memory_limit; ?></code></td>
                    <td>-</td>
                    <td><code>256M</code></td>
                </tr>
            </tbody>
        </table>

        <?php if ($upload_bytes < 104857600 || $post_bytes <= $upload_bytes || $max_execution < 300): ?>
        <div class="alert alert-warning">
            <strong>⚠️ Acción Requerida</strong><br><br>
            Tu configuración actual puede causar problemas al subir videos grandes.
            <br><br>
            <strong>Pasos para corregir:</strong><br>
            1. Abre el archivo: <code>c:\xampp\php\php.ini</code><br>
            2. Busca y modifica los valores según la tabla arriba<br>
            3. Reinicia Apache en el Panel de Control de XAMPP<br>
            4. Recarga esta página para verificar los cambios<br>
            <br>
            📖 <a href="AUMENTAR_LIMITE_PHP.md" target="_blank">Ver instrucciones detalladas</a>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <strong>✅ Configuración Correcta</strong><br><br>
            Tu servidor está configurado correctamente para subir archivos grandes.
            Puedes subir videos de hasta <strong><?php echo $upload_max; ?></strong>.
        </div>
        <?php endif; ?>

        <h3>📍 Ubicación del archivo php.ini</h3>
        <code><?php echo php_ini_loaded_file(); ?></code>

        <p style="text-align: center; margin-top: 30px;">
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>" style="color: #6D28D9; text-decoration: none;">← Volver a Learnly</a>
        </p>
    </div>
</body>
</html>
