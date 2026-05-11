<?php ob_start(); ?>

<div class="container" style="max-width: 900px; margin: 2rem auto;">
    <div class="card">
        <div class="card-body">
            <h1 class="mb-3"><?php echo $leccion['titulo']; ?></h1>
            
            <?php 
            // Detectar tipo de contenido automáticamente si no está definido
            $tipoContenido = $leccion['tipo_contenido'];
            if (empty($tipoContenido) && !empty($leccion['url_contenido'])) {
                $url = $leccion['url_contenido'];
                if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false || strpos($url, 'vimeo.com') !== false) {
                    $tipoContenido = 'video';
                } elseif (strpos($url, '/uploads/videos/') !== false) {
                    $tipoContenido = 'video_archivo';
                } elseif (strpos($url, '/uploads/') !== false) {
                    $tipoContenido = 'documento';
                }
            }
            ?>
            
            <?php if (($tipoContenido === 'video' || $tipoContenido === 'video_archivo') && $leccion['url_contenido']): ?>
                <?php if (strpos($leccion['url_contenido'], 'youtube.com') !== false || strpos($leccion['url_contenido'], 'vimeo.com') !== false): ?>
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; margin-bottom: 2rem;">
                        <iframe 
                            src="<?php echo $leccion['url_contenido']; ?>" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 0.5rem;"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php else: ?>
                    <div style="margin-bottom: 2rem;">
                        <video controls style="width: 100%; border-radius: 0.5rem;">
                            <source src="<?php echo $leccion['url_contenido']; ?>" type="video/mp4">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if ($leccion['contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <h3 class="mb-2">Contenido de la Lección</h3>
                    <p style="white-space: pre-line;"><?php echo htmlspecialchars($leccion['contenido']); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (($tipoContenido === 'documento' || $tipoContenido === 'pdf' || $tipoContenido === 'word') && $leccion['url_contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <a href="<?php echo $leccion['url_contenido']; ?>" class="btn btn-secondary" target="_blank">
                        📄 Ver/Descargar Documento
                    </a>
                </div>
            <?php endif; ?>
            
            <?php if ($tipoContenido === 'recurso' && $leccion['url_contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <a href="<?php echo $leccion['url_contenido']; ?>" class="btn btn-secondary" download>
                        📦 Descargar Recurso
                    </a>
                </div>
            <?php endif; ?>
            
            <?php if (empty($leccion['contenido']) && empty($leccion['url_contenido'])): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ Esta lección aún no tiene contenido.</strong>
                    <p>El instructor todavía no ha cargado el material para esta lección.</p>
                </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <button onclick="marcarCompletada(<?php echo $leccion['id']; ?>)" class="btn btn-primary">
                    ✔ Marcar como Completada
                </button>
                <a href="javascript:history.back()" class="btn btn-outline">← Volver al Curso</a>
            </div>
        </div>
    </div>
</div>

<script>
function marcarCompletada(leccionId) {
    fetch('<?php echo BASE_URL; ?>aprendiz/marcarCompletada', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'leccion_id=' + leccionId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Lección completada!');
            history.back();
        }
    });
}
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

