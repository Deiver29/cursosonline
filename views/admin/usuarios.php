<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>admin/dashboard">📊 Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/usuarios" class="active">👥 Usuarios</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/cursos">📚 Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>admin/estadisticas">📈 Estadísticas</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Gestión de Usuarios</h1>
        
        <form method="GET" class="mb-3">
            <div style="display: flex; gap: 1rem;">
                <input type="text" name="busqueda" placeholder="Buscar por nombre o email..." class="form-control" value="<?php echo $_GET['busqueda'] ?? ''; ?>" style="flex: 1;">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>País</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><span class="badge badge-info"><?php echo ucfirst($usuario['rol']); ?></span></td>
                        <td><?php echo $usuario['pais']; ?></td>
                        <td>
                            <span class="badge <?php echo $usuario['activo'] ? 'badge-success' : 'badge-danger'; ?>">
                                <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></td>
                        <td>
                            <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                <button onclick="cambiarEstado(<?php echo $usuario['id']; ?>, <?php echo $usuario['activo'] ? 0 : 1; ?>)" 
                                        class="btn btn-small <?php echo $usuario['activo'] ? 'btn-danger' : 'btn-secondary'; ?>">
                                    <?php echo $usuario['activo'] ? 'Desactivar' : 'Activar'; ?>
                                </button>
                                <a href="<?php echo BASE_URL; ?>admin/eliminarUsuario/<?php echo $usuario['id']; ?>" 
                                   class="btn btn-danger btn-small" 
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function cambiarEstado(usuarioId, nuevoEstado) {
    fetch('<?php echo BASE_URL; ?>admin/cambiarEstadoUsuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'usuario_id=' + usuarioId + '&activo=' + nuevoEstado
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

