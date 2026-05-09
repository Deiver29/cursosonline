<!DOCTYPE html>
<html lang="<?php echo $_SESSION['idioma'] ?? 'es'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <img src="<?php echo BASE_URL; ?>assets/images/Learnly.png" alt="Learnly" class="logo-img">
                </a>
                
                <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>home/index">Cursos</a></li>
                    
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>carrito">🛒 Carrito</a></li>
                        
                        <?php if ($_SESSION['usuario_rol'] === 'aprendiz'): ?>
                            <li><a href="<?php echo BASE_URL; ?>aprendiz/dashboard">Mi Panel</a></li>
                        <?php elseif ($_SESSION['usuario_rol'] === 'capacitador'): ?>
                            <li><a href="<?php echo BASE_URL; ?>capacitador/dashboard">Mi Panel</a></li>
                        <?php elseif ($_SESSION['usuario_rol'] === 'administrador'): ?>
                            <li><a href="<?php echo BASE_URL; ?>admin/dashboard">Panel Admin</a></li>
                        <?php endif; ?>
                        
                        <li><a href="<?php echo BASE_URL; ?>auth/logout" class="btn btn-small btn-danger">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-small btn-outline">Iniciar Sesión</a></li>
                        <li><a href="<?php echo BASE_URL; ?>auth/registro" class="btn btn-small btn-primary">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="container mt-2">
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']);
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php echo $contenido ?? ''; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <h4><?php echo SITE_NAME; ?></h4>
                    <p>Plataforma educativa internacional</p>
                </div>
                <div>
                    <h4>Enlaces</h4>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                        <li><a href="<?php echo BASE_URL; ?>home/index">Cursos</a></li>
                        <li><a href="#">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Soporte</h4>
                    <ul>
                        <li><a href="#">Centro de Ayuda</a></li>
                        <li><a href="#">Términos de Servicio</a></li>
                        <li><a href="#">Privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }
    </script>
</body>
</html>

