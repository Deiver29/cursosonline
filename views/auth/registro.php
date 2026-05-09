<?php ob_start(); ?>

<div class="container" style="max-width: 600px; margin: 4rem auto;">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-3">Registrarse</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>auth/registro">
                <div class="form-group">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label class="form-label">País</label>
                    <input type="text" name="pais" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Idioma Preferido</label>
                    <select name="idioma" class="form-control" required>
                        <option value="es">Español</option>
                        <option value="en">English</option>
                        <option value="fr">Français</option>
                        <option value="pt">Português</option>
                        <option value="de">Deutsch</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tipo de Usuario</label>
                    <select name="rol" class="form-control" required>
                        <option value="aprendiz">Aprendiz (Estudiante)</option>
                        <option value="capacitador">Capacitador (Instructor)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Registrarse</button>
            </form>
            
            <p class="text-center mt-3">
                ¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>auth/login">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

