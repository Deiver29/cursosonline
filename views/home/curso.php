<?php ob_start(); ?>

<div class="container" style="padding: 3rem 0;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <h1 class="mb-2"><?php echo $curso['titulo']; ?></h1>
            
            <div class="d-flex align-center gap-2 mb-3">
                <div class="rating">
                    <?php 
                    $rating = round($curso['calificacion_promedio'] ?? 0);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating ? 'â­' : 'â˜†';
                    }
                    ?>
                    <span style="color: #6b7280; margin-left: 0.5rem;">
                        (<?php echo number_format($curso['calificacion_promedio'] ?? 0, 1); ?> - <?php echo $curso['total_resenas']; ?> reseñas)
                    </span>
                </div>
                <span class="badge badge-info"><?php echo ucfirst($curso['nivel']); ?></span>
                <span class="badge badge-warning"><?php echo $curso['idioma']; ?></span>
            </div>
            
            <p style="color: #6b7280; margin-bottom: 1rem;">
                Por: <strong><?php echo $curso['capacitador_nombre']; ?></strong> | 
                Categoría: <strong><?php echo $curso['categoria_nombre']; ?></strong>
            </p>
            
            <?php if ($curso['imagen_portada']): ?>
                <img src="<?php echo $curso['imagen_portada']; ?>" alt="<?php echo $curso['titulo']; ?>" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 2rem;">
            <?php endif; ?>
            
            <h2 class="mb-2">Descripción</h2>
            <p style="white-space: pre-line;"><?php echo $curso['descripcion']; ?></p>
            
            <h2 class="mt-4 mb-2">Contenido del Curso</h2>
            <div class="card">
                <div class="card-body">
                    <?php if (empty($modulos)): ?>
                        <p>Este curso aún no tiene contenido disponible.</p>
                    <?php else: ?>
                        <?php foreach ($modulos as $modulo): ?>
                            <div style="margin-bottom: 1.5rem;">
                                <h3><?php echo $modulo['titulo']; ?></h3>
                                <?php if ($modulo['descripcion']): ?>
                                    <p style="color: #6b7280;"><?php echo $modulo['descripcion']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <h2 class="mt-4 mb-2">Reseñas</h2>
            <?php if (empty($resenas)): ?>
                <p>Este curso aún no tiene reseñas.</p>
            <?php else: ?>
                <?php foreach ($resenas as $resena): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex align-center justify-between mb-1">
                                <strong><?php echo $resena['usuario_nombre']; ?></strong>
                                <div class="rating">
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $resena['calificacion'] ? '⭐' : '☆';
                                    }
                                    ?>
                                </div>
                            </div>
                            <p><?php echo $resena['comentario']; ?></p>
                            <small style="color: #6b7280;"><?php echo date('d/m/Y', strtotime($resena['fecha_creacion'])); ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div>
            <div class="card" style="position: sticky; top: 80px;">
                <div class="card-body">
                    <h2 class="text-center mb-3" style="font-size: 2rem; color: var(--primary-color);">
                        <?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?>
                    </h2>
                    
                    <?php if ($yaComprado): ?>
                        <a href="<?php echo BASE_URL; ?>aprendiz/verCurso/<?php echo $curso['id']; ?>" class="btn btn-secondary" style="width: 100%; margin-bottom: 1rem;">
                            Ir al Curso
                        </a>
                    <?php elseif (isset($_SESSION['usuario_id'])): ?>
                        <form method="POST" action="<?php echo BASE_URL; ?>carrito/agregar" onsubmit="agregarCarrito(event)">
                            <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                                Agregar al Carrito
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">
                            Inicia sesión para comprar
                        </a>
                    <?php endif; ?>
                    
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                        <h4 class="mb-2">Este curso incluye:</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">✔ Acceso de por vida</li>
                            <li style="margin-bottom: 0.5rem;">✔ Certificado de finalización</li>
                            <li style="margin-bottom: 0.5rem;">✔ Acceso en móvil y PC</li>
                            <li style="margin-bottom: 0.5rem;">✔ Recursos descargables</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function agregarCarrito(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Curso agregado al carrito');
            window.location.href = '<?php echo BASE_URL; ?>carrito';
        } else {
            alert(data.message || 'Error al agregar al carrito');
        }
    });
}
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

