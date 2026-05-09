<?php ob_start(); ?>

<div class="container dashboard">
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>aprendiz/dashboard">📊 Panel Principal</a></li>
            <li><a href="<?php echo BASE_URL; ?>aprendiz/misCursos">📚 Mis Cursos</a></li>
            <li><a href="<?php echo BASE_URL; ?>aprendiz/perfil" class="active">👤 Mi Perfil</a></li>
            <li><a href="<?php echo BASE_URL; ?>">🏠 Inicio</a></li>
        </ul>
    </aside>
    
    <div class="dashboard-content">
        <h1 class="mb-4">Mi Perfil</h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>aprendiz/perfil">
                    <div class="form-group">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" value="<?php echo $usuario['email']; ?>" disabled>
                        <small style="color: #6b7280;">El email no se puede cambiar</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">URL de Foto de Perfil</label>
                        <input type="text" name="foto" class="form-control" value="<?php echo $usuario['foto']; ?>">
                        <small style="color: #6b7280;">Ingresa la URL de tu foto</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">País</label>
                        <input type="text" name="pais" class="form-control" value="<?php echo $usuario['pais']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Biografía</label>
                        <textarea name="biografia" class="form-control"><?php echo $usuario['biografia']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Idioma Preferido</label>
                        <select name="idioma" class="form-control">
                            <option value="es" <?php echo $usuario['idioma_preferido'] == 'es' ? 'selected' : ''; ?>>Español</option>
                            <option value="en" <?php echo $usuario['idioma_preferido'] == 'en' ? 'selected' : ''; ?>>English</option>
                            <option value="fr" <?php echo $usuario['idioma_preferido'] == 'fr' ? 'selected' : ''; ?>>Français</option>
                            <option value="pt" <?php echo $usuario['idioma_preferido'] == 'pt' ? 'selected' : ''; ?>>Português</option>
                            <option value="de" <?php echo $usuario['idioma_preferido'] == 'de' ? 'selected' : ''; ?>>Deutsch</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

