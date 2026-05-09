<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>aprendiz/dashboard">📊 Panel Principal</a></li>
            <li><a href="<?php echo BASE_URL; ?>aprendiz/misCursos" class="active">📚 Mis Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>aprendiz/perfil">👤 Mi Perfil</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Mis Cursos</h1>
        
        <?php if (empty($cursos)): ?>
            <div class="card">
                <div class="card-body text-center" style="padding: 3rem;">
                    <h3 class="mb-2">No tienes cursos inscritos</h3>
                    <p style="color: #6b7280; margin-bottom: 2rem;">Explora nuestro catálogo y comienza a aprender hoy</p>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Explorar Cursos</a>
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
                                <?php echo $curso['capacitador_nombre']; ?>
                            </p>
                            
                            <div class="mb-2">
                                <div class="d-flex justify-between mb-1">
                                    <small>Progreso del Curso</small>
                                    <small>
                                        <?php 
                                        $porcentaje = $curso['total_lecciones'] > 0 
                                            ? round(($curso['lecciones_completadas'] / $curso['total_lecciones']) * 100) 
                                            : 0;
                                        echo $porcentaje;
                                        ?>%
                                    </small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?php echo $porcentaje; ?>%"></div>
                                </div>
                                <p style="font-size: 0.875rem; margin-top: 0.5rem;">
                                    <?php echo $curso['lecciones_completadas']; ?> de <?php echo $curso['total_lecciones']; ?> lecciones completadas
                                </p>
                            </div>
                            
                            <a href="<?php echo BASE_URL; ?>aprendiz/verCurso/<?php echo $curso['id']; ?>" class="btn btn-primary" style="width: 100%;">
                                Ver Curso
                            </a>
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

