<?php ob_start(); ?>

<div class="container" style="max-width: 800px; margin: 3rem auto;">
    <h1 class="mb-4 text-center">Finalizar Compra</h1>
    
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="mb-3">Resumen de tu Compra</h3>
            
            <?php foreach ($cursos as $curso): ?>
                <div class="d-flex justify-between mb-2" style="padding: 0.5rem 0; border-bottom: 1px solid var(--border-color);">
                    <span><?php echo $curso['titulo']; ?></span>
                    <strong><?php echo $curso['moneda']; ?> <?php echo number_format($curso['precio'], 2); ?></strong>
                </div>
            <?php endforeach; ?>
            
            <div class="d-flex justify-between mt-3" style="font-size: 1.25rem;">
                <strong>Total a Pagar:</strong>
                <strong style="color: var(--primary-color);">$ <?php echo number_format($total, 2); ?></strong>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Método de Pago</h3>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Selecciona el método de pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="">Selecciona una opción</option>
                        <option value="tarjeta_credito">Tarjeta de Crédito</option>
                        <option value="tarjeta_debito">Tarjeta de Débito</option>
                        <option value="paypal">PayPal</option>
                        <option value="transferencia">Transferencia Bancaria</option>
                    </select>
                </div>
                
                <div class="alert alert-info">
                    <strong>Nota:</strong> Este es un proyecto educativo. El sistema de pago es simulado.
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Confirmar Compra
                </button>
                
                <a href="<?php echo BASE_URL; ?>carrito" class="btn btn-outline mt-2" style="width: 100%;">
                    Volver al Carrito
                </a>
            </form>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>

