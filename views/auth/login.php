<?php ob_start(); ?>

<div class="container" style="max-width: 500px; margin: 4rem auto;">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-3">Iniciar Sesión</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>auth/login">
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Iniciar Sesión</button>
            </form>
            
            <p class="text-center mt-3">
                ¿No tienes cuenta? <a href="<?php echo BASE_URL; ?>auth/registro">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

