<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>capacitador/dashboard" class="active">📊 Panel Principal</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/misCursos">📚 Mis Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>capacitador/crearCurso">➕ Crear Curso</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-3">Panel del Capacitador</h1>
        
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <h3><?php echo count($cursos); ?></h3>
                <p>Total de Cursos</p>
            </div>
            <div class="stat-card">
                <h3>
                    <?php 
                    $publicados = array_filter($cursos, function($c) { return $c['publicado'] == 1; });
                    echo count($publicados);
                    ?>
                </h3>
                <p>Cursos Publicados</p>
            </div>
            <div class="stat-card">
                <h3>
                    <?php 
                    $aprobados = array_filter($cursos, function($c) { return $c['aprobado'] == 1; });
                    echo count($aprobados);
                    ?>
                </h3>
                <p>Cursos Aprobados</p>
            </div>
            <div class="stat-card">
                <h3>
                    <?php 
                    $totalEstudiantes = 0;
                    foreach ($cursos as $curso) {
                        $totalEstudiantes += $curso['total_estudiantes'] ?? 0;
                    }
                    echo $totalEstudiantes;
                    ?>
                </h3>
                <p>Total Estudiantes</p>
            </div>
        </div>
        
        <div class="d-flex justify-between align-center mb-3">
            <h2>Mis Cursos</h2>
            <a href="<?php echo BASE_URL; ?>capacitador/crearCurso" class="btn btn-primary">âž• Crear Nuevo Curso</a>
        </div>
        
        <?php if (empty($cursos)): ?>
            <div class="card">
                <div class="card-body text-center" style="padding: 3rem;">
                    <h3 class="mb-2">No has creado cursos aún</h3>
                    <p style="color: #6b7280; margin-bottom: 2rem;">Crea tu primer curso y comienza a compartir tu conocimiento</p>
                    <a href="<?php echo BASE_URL; ?>capacitador/crearCurso" class="btn btn-primary">Crear Mi Primer Curso</a>
                </div>
            </div>
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
                                <?php echo $curso['categoria_nombre']; ?>
                            </p>
                            
                            <div class="d-flex gap-1 mb-2">
                                <span class="badge <?php echo $curso['publicado'] ? 'badge-success' : 'badge-warning'; ?>">
                                    <?php echo $curso['publicado'] ? 'Publicado' : 'Borrador'; ?>
                                </span>
                                <span class="badge <?php echo $curso['aprobado'] ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $curso['aprobado'] ? 'Aprobado' : 'Pendiente'; ?>
                                </span>
                            </div>
                            
                            <div class="d-flex justify-between align-center">
                                <div>
                                    <p style="margin: 0; font-size: 0.875rem;">
                                        ⭐ <?php echo number_format($curso['calificacion_promedio'] ?? 0, 1); ?>
                                    </p>
                                    <p style="margin: 0; font-size: 0.875rem;">
                                        👥 <?php echo $curso['total_estudiantes'] ?? 0; ?> estudiantes
                                    </p>
                                </div>
                                <a href="<?php echo BASE_URL; ?>capacitador/editarCurso/<?php echo $curso['id']; ?>" class="btn btn-primary btn-small">
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

