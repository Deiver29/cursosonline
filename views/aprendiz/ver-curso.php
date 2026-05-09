<?php ob_start(); ?>

<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="<?php echo BASE_URL; ?>aprendiz/misCursos" class="btn btn-outline">← Volver a Mis Cursos</a>
    </div>
    
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
        <aside>
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-2"><?php echo $curso['titulo']; ?></h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                        <?php echo $curso['capacitador_nombre']; ?>
                    </p>
                    
                    <div class="mb-3">
                        <h4 style="font-size: 0.875rem; margin-bottom: 0.5rem;">Progreso General</h4>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo $progreso['porcentaje'] ?? 0; ?>%"></div>
                        </div>
                        <p style="font-size: 0.875rem; margin-top: 0.5rem; text-align: center;">
                            <?php echo $progreso['porcentaje'] ?? 0; ?>% Completado
                        </p>
                    </div>
                    
                    <h4 style="font-size: 0.875rem; margin-bottom: 0.5rem;">Contenido del Curso</h4>
                    
                    <?php foreach ($modulos as $modulo): ?>
                        <div style="margin-bottom: 1rem;">
                            <strong style="font-size: 0.875rem;"><?php echo $modulo['titulo']; ?></strong>
                            <ul style="list-style: none; padding-left: 0; margin-top: 0.5rem;">
                                <?php foreach ($modulo['lecciones'] as $leccion): ?>
                                    <li style="margin-bottom: 0.25rem;">
                                        <a href="<?php echo BASE_URL; ?>aprendiz/verLeccion/<?php echo $leccion['id']; ?>" 
                                           style="font-size: 0.875rem; text-decoration: none; color: <?php echo $leccion['completado'] ? 'var(--secondary-color)' : 'var(--text-color)'; ?>;">
                                            <?php echo $leccion['completado'] ? '✔' : '○'; ?> <?php echo $leccion['titulo']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
        
        <main>
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3">Bienvenido al Curso</h1>
                    <p style="white-space: pre-line;"><?php echo $curso['descripcion']; ?></p>
                    
                    <div class="mt-4">
                        <h2 class="mb-2">Comenzar a Aprender</h2>
                        <p>Selecciona una lección del menú lateral para comenzar.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

