<?php ob_start(); ?>

<div class="container" style="padding: 3rem 0;">
    <h2 class="section-title">Catálogo de Cursos</h2>
    <p class="section-subtitle">Todos los cursos creados y aprobados disponibles para compra</p>
    <div class="catalog-filtros" style="margin: 1.5rem 0;">
        <?php
            $q = isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '';
            $catSel = isset($_GET['categoria']) ? (int)$_GET['categoria'] : '';
            $nivelSel = isset($_GET['nivel']) ? htmlspecialchars($_GET['nivel']) : '';
        ?>
        <form id="filtroForm" method="get" action="<?php echo BASE_URL; ?>home/catalogo" style="display:flex; gap:0.5rem; align-items:center;">
            <input type="text" name="busqueda" placeholder="Buscar cursos..." value="<?php echo $q; ?>" style="flex:1; padding:0.5rem;">
            <select name="categoria" onchange="document.getElementById('filtroForm').submit()" style="padding:0.5rem;">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $catSel === (int)$cat['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="nivel" onchange="document.getElementById('filtroForm').submit()" style="padding:0.5rem;">
                <option value="">Todos los niveles</option>
                <option value="basico" <?php echo $nivelSel === 'basico' ? 'selected' : ''; ?>>Básico</option>
                <option value="intermedio" <?php echo $nivelSel === 'intermedio' ? 'selected' : ''; ?>>Intermedio</option>
                <option value="avanzado" <?php echo $nivelSel === 'avanzado' ? 'selected' : ''; ?>>Avanzado</option>
            </select>
            <button type="submit" class="btn btn-outline">Buscar</button>
        </form>
    </div>

    <?php if (empty($cursos)): ?>
        <p class="text-center">No hay cursos disponibles en este momento.</p>
    <?php else: ?>
        <div class="cursos-grid">
            <?php foreach ($cursos as $curso): ?>
                <div class="card">
                    <?php if ($curso['imagen_portada']): ?>
                        <img src="<?php echo $curso['imagen_portada']; ?>" alt="<?php echo $curso['titulo']; ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h3 class="card-title"><?php echo $curso['titulo']; ?></h3>
                        <p class="card-text" style="font-size: 0.875rem; color: #6b7280;">
                            <?php echo $curso['capacitador_nombre']; ?> • <?php echo $curso['categoria_nombre']; ?>
                        </p>
                        <p class="card-text"><?php echo substr($curso['descripcion'], 0, 120); ?>...</p>

                        <div class="d-flex align-center justify-between mb-2">
                            <div class="rating">
                                <?php 
                                $rating = round($curso['calificacion_promedio'] ?? 0);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '⭐' : '☆';
                                }
                                ?>
                                <span style="color: #6b7280; margin-left: 0.5rem;">(<?php echo number_format($curso['calificacion_promedio'] ?? 0, 1); ?>)</span>
                            </div>
                            <div>
                                <span class="badge badge-info"><?php echo ucfirst($curso['nivel']); ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-center justify-between">
                            <strong style="font-size: 1.25rem; color: var(--primary-color);">
                                <?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?>
                            </strong>
                            <div style="display:flex; gap:0.5rem; align-items:center;">
                                <a href="<?php echo BASE_URL; ?>home/curso/<?php echo $curso['id']; ?>" class="btn btn-outline btn-small">Ver</a>

                                <?php if (isset($_SESSION['usuario_id'])): ?>
                                    <form method="POST" action="<?php echo BASE_URL; ?>carrito/agregar" class="form-agregar" data-curso="<?php echo $curso['id']; ?>">
                                        <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-small">Agregar</button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary btn-small">Inicia sesión</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.form-agregar').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const fd = new FormData(form);
        fetch(form.action, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Curso agregado al carrito');
                    window.location.href = '<?php echo BASE_URL; ?>carrito';
                } else {
                    alert(data.message || 'No se pudo agregar al carrito');
                }
            })
            .catch(() => alert('Error de red'));
    });
});
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>
