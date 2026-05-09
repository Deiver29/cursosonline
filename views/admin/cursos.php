<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>admin/dashboard">📊 Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/usuarios">👥 Usuarios</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/cursos" class="active">📚 Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/estadisticas">📈 Estadísticas</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Gestión de Cursos</h1>
        
        <h2 class="mb-3">Cursos Pendientes de Aprobación</h2>
        
        <?php if (empty($cursosPendientes)): ?>
            <div class="card">
                <div class="card-body text-center">
                    <p>No hay cursos pendientes de aprobación</p>
                </div>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Capacitador</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursosPendientes as $curso): ?>
                        <tr>
                            <td><?php echo $curso['titulo']; ?></td>
                            <td><?php echo $curso['capacitador_nombre']; ?></td>
                            <td><?php echo $curso['categoria_nombre']; ?></td>
                            <td><?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($curso['fecha_creacion'])); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>home/curso/<?php echo $curso['id']; ?>" class="btn btn-primary btn-small" target="_blank">Ver</a>
                                <a href="<?php echo BASE_URL; ?>admin/aprobarCurso/<?php echo $curso['id']; ?>" class="btn btn-secondary btn-small">Aprobar</a>
                                <a href="<?php echo BASE_URL; ?>admin/rechazarCurso/<?php echo $curso['id']; ?>" class="btn btn-warning btn-small">Rechazar</a>
                                <a href="<?php echo BASE_URL; ?>admin/eliminarCurso/<?php echo $curso['id']; ?>" 
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

