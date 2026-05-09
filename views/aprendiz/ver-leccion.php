<?php ob_start(); ?>

<div class="container" style="max-width: 900px; margin: 2rem auto;">
    <div class="card">
        <div class="card-body">
            <h1 class="mb-3"><?php echo $leccion['titulo']; ?></h1>
            
            <?php if ($leccion['tipo_contenido'] === 'video' && $leccion['url_contenido']): ?>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; margin-bottom: 2rem;">
                    <iframe 
                        src="<?php echo $leccion['url_contenido']; ?>" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 0.5rem;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php endif; ?>
            
            <?php if ($leccion['contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <h3 class="mb-2">Contenido de la Lección</h3>
                    <p style="white-space: pre-line;"><?php echo $leccion['contenido']; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($leccion['tipo_contenido'] === 'documento' && $leccion['url_contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <a href="<?php echo $leccion['url_contenido']; ?>" class="btn btn-secondary" download>
                        📄 Descargar Documento
                    </a>
                </div>
            <?php endif; ?>
            
            <?php if ($leccion['tipo_contenido'] === 'recurso' && $leccion['url_contenido']): ?>
                <div style="margin-bottom: 2rem;">
                    <a href="<?php echo $leccion['url_contenido']; ?>" class="btn btn-secondary" download>
                        📦 Descargar Recurso
                    </a>
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

