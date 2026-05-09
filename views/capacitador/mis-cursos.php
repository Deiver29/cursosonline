<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>capacitador/dashboard">📊 Panel Principal</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/misCursos" class="active">📚 Mis Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/crearCurso">➕ Crear Curso</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Mis Cursos</h1>
        
        <?php if (empty($cursos)): ?>
            <div class="card">
                <div class="card-body text-center" style="padding: 3rem;">
                    <h3 class="mb-2">No has creado cursos aún</h3>
                    <p style="color: #6b7280; margin-bottom: 2rem;">Crea tu primer curso y comienza a compartir tu conocimiento</p>
                    <a href="<?php echo BASE_URL; ?>capacitador/crearCurso" class="btn btn-primary">Crear Mi Primer Curso</a>
                </div>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Estudiantes</th>
                        <th>Calificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?php echo $curso['titulo']; ?></td>
                            <td><?php echo $curso['categoria_nombre']; ?></td>
                            <td><?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?></td>
                            <td>
                                <span class="badge <?php echo $curso['publicado'] ? 'badge-success' : 'badge-warning'; ?>">
                                    <?php echo $curso['publicado'] ? 'Publicado' : 'Borrador'; ?>
                                </span>
                                <br>
                                <span class="badge <?php echo $curso['aprobado'] ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $curso['aprobado'] ? 'Aprobado' : 'Pendiente'; ?>
                                </span>
                            </td>
                            <td><?php echo $curso['total_estudiantes'] ?? 0; ?></td>
                            <td>⭐ <?php echo number_format($curso['calificacion_promedio'] ?? 0, 1); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>capacitador/editarCurso/<?php echo $curso['id']; ?>" class="btn btn-primary btn-small">Editar</a>
                                <a href="<?php echo BASE_URL; ?>capacitador/publicarCurso/<?php echo $curso['id']; ?>" class="btn btn-secondary btn-small">
                                    <?php echo $curso['publicado'] ? 'Despublicar' : 'Publicar'; ?>
                                </a>
                                <a href="<?php echo BASE_URL; ?>capacitador/eliminarCurso/<?php echo $curso['id']; ?>" 
                                   class="btn btn-danger btn-small" 
                                   onclick="return confirm('¿Estás seguro de eliminar este curso?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

