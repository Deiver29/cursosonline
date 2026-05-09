<?php ob_start(); ?>

<section class="hero">
    <div class="container">
        <h1>Aprende sin límites</h1>
        <p>Cursos de calidad mundial desde cualquier parte del planeta</p>
        <a href="#cursos" class="btn btn-primary" style="background: white; color: var(--primary-color);">Explorar Cursos</a>
    </div>
</section>

<div class="container">
    <div class="search-box">
        <form method="GET" action="<?php echo BASE_URL; ?>home/index" class="search-form">
            <div class="search-input">
                <input type="text" name="busqueda" placeholder="Buscar cursos..." class="form-control" value="<?php echo $_GET['busqueda'] ?? ''; ?>">
            </div>
            
            <div>
                <select name="categoria" class="form-control">
                    <option value="">Todas las Categorías</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo $cat['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <select name="idioma" class="form-control">
                    <option value="">Todos los Idiomas</option>
                    <option value="es" <?php echo (isset($_GET['idioma']) && $_GET['idioma'] == 'es') ? 'selected' : ''; ?>>Español</option>
                    <option value="en" <?php echo (isset($_GET['idioma']) && $_GET['idioma'] == 'en') ? 'selected' : ''; ?>>English</option>
                    <option value="fr" <?php echo (isset($_GET['idioma']) && $_GET['idioma'] == 'fr') ? 'selected' : ''; ?>>Français</option>
                    <option value="pt" <?php echo (isset($_GET['idioma']) && $_GET['idioma'] == 'pt') ? 'selected' : ''; ?>>Português</option>
                </select>
            </div>
            
            <div>
                <select name="nivel" class="form-control">
                    <option value="">Todos los Niveles</option>
                    <option value="basico" <?php echo (isset($_GET['nivel']) && $_GET['nivel'] == 'basico') ? 'selected' : ''; ?>>Básico</option>
                    <option value="intermedio" <?php echo (isset($_GET['nivel']) && $_GET['nivel'] == 'intermedio') ? 'selected' : ''; ?>>Intermedio</option>
                    <option value="avanzado" <?php echo (isset($_GET['nivel']) && $_GET['nivel'] == 'avanzado') ? 'selected' : ''; ?>>Avanzado</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
</div>

<div class="container" id="cursos" style="padding: 3rem 0;">
    <h2 class="mb-3">Cursos Disponibles</h2>
    
    <?php if (empty($cursos)): ?>
        <p class="text-center">No se encontraron cursos con los filtros seleccionados.</p>
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
                            <?php echo $curso['capacitador_nombre']; ?> â€¢ <?php echo $curso['categoria_nombre']; ?>
                        </p>
                        <p class="card-text"><?php echo substr($curso['descripcion'], 0, 100); ?>...</p>
                        
                        <div class="d-flex align-center justify-between mb-2">
                            <div class="rating">
                                <?php 
                                $rating = round($curso['calificacion_promedio'] ?? 0);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? 'â­' : 'â˜†';
                                }
                                ?>
                                <span style="color: #6b7280; margin-left: 0.5rem;">(<?php echo number_format($curso['calificacion_promedio'] ?? 0, 1); ?>)</span>
                            </div>
                            <div>
                                <span class="badge badge-info"><?php echo ucfirst($curso['nivel']); ?></span>
                            </div>
                        </div>
                        
                        <div class="d-flex align-center justify-between">
                            <strong style="font-size: 1.5rem; color: var(--primary-color);">
                                <?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?>
                            </strong>
                            <a href="<?php echo BASE_URL; ?>home/curso/<?php echo $curso['id']; ?>" class="btn btn-primary btn-small">Ver Curso</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

