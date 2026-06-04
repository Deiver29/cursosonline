<?php ob_start(); ?>

<!-- Hero Slider -->
<section class="hero-slider">
    <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://www.unisimon.edu.co/recursos/img/universidad-simon-bolivar-i84b5a.jpg');">
        <div class="slide-content">
            <h1>Transforma tu futuro con educación</h1>
            <p>Accede a cursos de calidad mundial diseñados para impulsar tu carrera profesional y personal. El conocimiento es la llave que abre todas las puertas.</p>
            <a href="#cursos" class="btn btn-hero">Explorar Cursos</a>
        </div>
    </div>
    <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://mercadeo.unisimon.edu.co/wp-content/uploads/2023/09/imagen8-min.jpg');">
        <div class="slide-content">
            <h1>Aprende a tu ritmo, donde quieras</h1>
            <p>Estudia desde cualquier dispositivo con acceso 24/7 a contenido actualizado. Tu aprendizaje no tiene horarios ni fronteras.</p>
            <a href="#cursos" class="btn btn-hero">Explorar Cursos</a>
        </div>
    </div>
    <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://mercadeo.unisimon.edu.co/wp-content/uploads/2023/09/ingenieria-sistemas-h-1024x683.jpg');">
        <div class="slide-content">
            <h1>Conviértete en un experto</h1>
            <p>Domina las habilidades más demandadas con instructores expertos y certificaciones que impulsarán tu perfil profesional.</p>
            <a href="#cursos" class="btn btn-hero">Explorar Cursos</a>
        </div>
    </div>
    <div class="slider-nav">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</section>

<!-- Stats / Logros -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid-home">
            <div class="stat-item">
                <div class="stat-icon">&#127891;</div>
                <h3>+500</h3>
                <p>Cursos Disponibles</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon">&#128101;</div>
                <h3>+10,000</h3>
                <p>Estudiantes Activos</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon">&#127775;</div>
                <h3>4.8/5</h3>
                <p>Calificación Promedio</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon">&#128179;</div>
                <h3>+100</h3>
                <p>Instructores Expertos</p>
            </div>
        </div>
    </div>
</section>

<!-- ¿Por qué estudiar? -->
<section class="benefits-section">
    <div class="container">
        <h2 class="section-title">¿Qué lograrás estudiando con nosotros?</h2>
        <p class="section-subtitle">Más que cursos, una experiencia transformadora que impulsa tu carrera y tu vida</p>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">&#128640;</div>
                <h3>Impulsa tu Carrera</h3>
                <p>Adquiere habilidades demandadas por las empresas líderes y acelera tu crecimiento profesional con certificaciones reconocidas.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">&#127760;</div>
                <h3>Perspectiva Global</h3>
                <p>Aprende de instructores de todo el mundo y conecta con una comunidad internacional de estudiantes apasionados por el conocimiento.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">&#128218;</div>
                <h3>Conocimiento Práctico</h3>
                <p>Proyectos reales, ejercicios interactivos y casos de estudio que te preparan para los desafíos del mundo laboral actual.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">&#128197;</div>
                <h3>Flexibilidad Total</h3>
                <p>Estudia cuando y donde quieras con acceso vitalicio al contenido. Tu ritmo, tus horarios, tu aprendizaje.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">&#128200;</div>
                <h3>Crecimiento Continuo</h3>
                <p>Mantente actualizado con contenido que se renueva constantemente para reflejar las últimas tendencias y tecnologías.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">&#129309;</div>
                <h3>Red de Contactos</h3>
                <p>Forma parte de una comunidad vibrante de profesionales y mentores que te apoyarán en cada paso de tu camino educativo.</p>
            </div>
        </div>
    </div>
</section>

<!-- Cursos Destacados -->
<div class="container" id="cursos" style="padding: 3rem 0;">
    <h2 class="section-title">Cursos Disponibles</h2>
    <p class="section-subtitle">Selección de los mejores cursos para impulsar tu aprendizaje</p>
    
    <?php if (empty($cursosDestacados)): ?>
        <p class="text-center">No se encontraron cursos disponibles.</p>
    <?php else: ?>
        <div class="cursos-grid">
            <?php foreach ($cursosDestacados as $curso): ?>
                <div class="card">
                    <?php if ($curso['imagen_portada']): ?>
                        <img src="<?php echo $curso['imagen_portada']; ?>" alt="<?php echo $curso['titulo']; ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $curso['titulo']; ?></h3>
                        <p class="card-text" style="font-size: 0.875rem; color: #6b7280;">
                            <?php echo $curso['capacitador_nombre']; ?> • <?php echo $curso['categoria_nombre']; ?>
                        </p>
                        <p class="card-text"><?php echo substr($curso['descripcion'], 0, 100); ?>...</p>
                        
                        <div class="d-flex align-center justify-between mb-2">
                            <div class="rating">
                                <?php 
                                $rating = round($curso['calificacion_promedio'] ?? 0);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '⭐' : '☆';
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
        
        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL; ?>home/index" class="btn btn-primary">Ver todos los cursos</a>
        </div>
    <?php endif; ?>
</div>

<!-- CTA Final -->
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para comenzar tu transformación?</h2>
        <p>Únete a miles de estudiantes que ya están construyendo un mejor futuro. El mejor momento para empezar es hoy.</p>
        <div class="cta-buttons">
            <a href="<?php echo BASE_URL; ?>auth/registro" class="btn btn-cta">Comienza Gratis</a>
            <a href="<?php echo BASE_URL; ?>home/index" class="btn btn-cta-outline">Explorar Cursos</a>
        </div>
    </div>
</section>

<script>
var slideIndex = 1;
showSlides(slideIndex);

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("slide");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    slides[slideIndex-1].classList.add("active");
    dots[slideIndex-1].classList.add("active");
}

// Auto-slide cada 5 segundos
setInterval(function() {
    slideIndex++;
    showSlides(slideIndex);
}, 5000);
</script>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>
