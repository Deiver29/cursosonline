<?php ob_start(); ?>

<div class="container" style="padding: 3rem 0;">
    <h1 class="mb-4">Carrito de Compras</h1>
    
    <?php if (empty($cursos)): ?>
        <div class="card">
            <div class="card-body text-center" style="padding: 3rem;">
                <h2 class="mb-2">Tu carrito está vacío</h2>
                <p style="color: #6b7280; margin-bottom: 2rem;">Explora nuestro catálogo y agrega cursos</p>
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Explorar Cursos</a>
            </div>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div>
                <?php foreach ($cursos as $curso): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div style="display: flex; gap: 1rem;">
                                <?php if ($curso['imagen_portada']): ?>
                                    <img src="<?php echo $curso['imagen_portada']; ?>" alt="<?php echo $curso['titulo']; ?>" style="width: 150px; height: 100px; object-fit: cover; border-radius: 0.5rem;">
                                <?php endif; ?>
                                
                                <div style="flex: 1;">
                                    <h3><?php echo $curso['titulo']; ?></h3>
                                    <p style="color: #6b7280; font-size: 0.875rem;">
                                        <?php echo $curso['capacitador_nombre']; ?> â€¢ <?php echo $curso['categoria_nombre']; ?>
                                    </p>
                                    
                                    <div class="d-flex justify-between align-center mt-2">
                                        <strong style="font-size: 1.25rem; color: var(--primary-color);">
                                            <?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?>
                                        </strong>
                                        
                                        <form method="POST" action="<?php echo BASE_URL; ?>carrito/eliminar">
                                            <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-small">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div>
                <div class="card" style="position: sticky; top: 80px;">
                    <div class="card-body">
                        <h2 class="mb-3">Resumen de Compra</h2>
                        
                        <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <div class="d-flex justify-between mb-2">
                                <span>Subtotal:</span>
                                <strong>$ <?php echo number_format($total, 2); ?></strong>
                            </div>
                            
                            <div class="d-flex justify-between mb-3" style="font-size: 1.25rem;">
                                <strong>Total:</strong>
                                <strong style="color: var(--primary-color);">$ <?php echo number_format($total, 2); ?></strong>
                            </div>
                        </div>
                        
                        <a href="<?php echo BASE_URL; ?>carrito/checkout" class="btn btn-primary" style="width: 100%;">
                            Proceder al Pago
                        </a>
                        
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline mt-2" style="width: 100%;">
                            Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

