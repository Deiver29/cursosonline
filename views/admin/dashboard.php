<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>admin/dashboard" class="active">📊 Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/usuarios">👥 Usuarios</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/cursos">📚 Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/estadisticas">📈 Estadísticas</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Panel de Administración</h1>
        
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <h3><?php echo $totalUsuarios; ?></h3>
                <p>Total Usuarios</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $totalCursos; ?></h3>
                <p>Total Cursos</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $totalCompras; ?></h3>
                <p>Total Compras</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count($cursosPendientes); ?></h3>
                <p>Cursos Pendientes</p>
            </div>
        </div>
        
        <h2 class="mb-3">Cursos Pendientes de Aprobación</h2>
        
        <?php if (empty($cursosPendientes)): ?>
            <div class="card">
                <div class="card-body text-center" style="padding: 3rem;">
                    <h3 class="mb-2">No hay cursos pendientes</h3>
                    <p style="color: #6b7280;">Todos los cursos están aprobados o rechazados</p>
                </div>
            </div>
        <?php else: ?>
            <div class="table">
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Capacitador</th>
                            <th>Categoría</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursosPendientes as $curso): ?>
                            <tr>
                                <td><?php echo $curso['titulo']; ?></td>
                                <td><?php echo $curso['capacitador_nombre']; ?></td>
                                <td><?php echo $curso['categoria_nombre']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($curso['fecha_creacion'])); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>home/curso/<?php echo $curso['id']; ?>" class="btn btn-primary btn-small" target="_blank">Ver</a>
                                    <a href="<?php echo BASE_URL; ?>admin/aprobarCurso/<?php echo $curso['id']; ?>" class="btn btn-secondary btn-small">Aprobar</a>
                                    <a href="<?php echo BASE_URL; ?>admin/rechazarCurso/<?php echo $curso['id']; ?>" class="btn btn-danger btn-small">Rechazar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

