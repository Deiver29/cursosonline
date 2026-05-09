<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>admin/dashboard">📊 Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/usuarios">👥 Usuarios</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/cursos">📚 Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/estadisticas" class="active">📈 Estadísticas</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Estadísticas del Sistema</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="mb-3">Usuarios por Rol</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['usuarios_por_rol'] as $stat): ?>
                            <tr>
                                <td><?php echo ucfirst($stat['rol']); ?></td>
                                <td><?php echo $stat['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="mb-3">Cursos por Categoría</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['cursos_por_categoria'] as $stat): ?>
                            <tr>
                                <td><?php echo $stat['nombre']; ?></td>
                                <td><?php echo $stat['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3">Ingresos Mensuales</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['ingresos_mensuales'] as $stat): ?>
                            <tr>
                                <td><?php echo $stat['mes']; ?></td>
                                <td>$ <?php echo number_format($stat['total'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

