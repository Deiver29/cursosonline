<?php
/**
 * ============================================
 * PLANTILLA DE CONFIGURACIÓN DE EMAIL
 * ============================================
 * Copia este archivo a Email.php y configura
 * tus credenciales SMTP
 * ============================================
 */

/**
 * Clase para envío de emails
 * Utiliza PHPMailer o mail() nativo de PHP
 */
class Email {
    
    /**
     * Enviar email usando la función mail() de PHP
     * 
     * @param string $destinatario Email del destinatario
     * @param string $nombre Nombre del destinatario
     * @param string $asunto Asunto del email
     * @param string $mensaje Mensaje en HTML
     * @return bool True si se envió correctamente
     */
    public static function enviar($destinatario, $nombre, $asunto, $mensaje) {
        // Configurar headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: TuApp <noreply@tuapp.com>" . "\r\n";
        $headers .= "Reply-To: soporte@tuapp.com" . "\r\n";
        
        // Plantilla HTML
        $plantilla = self::obtenerPlantilla($nombre, $mensaje);
        
        // Enviar email
        return mail($destinatario, $asunto, $plantilla, $headers);
    }
    
    /**
     * Enviar email de bienvenida al registrarse
     */
    public static function enviarBienvenida($destinatario, $nombre) {
        $asunto = "¡Bienvenido a Learnly! 🎓";
        
        $mensaje = "
            <h2>¡Tu cuenta ha sido creada exitosamente!</h2>
            <p>Hola <strong>{$nombre}</strong>,</p>
            <p>Gracias por unirte a <strong>Learnly</strong>, tu marketplace educativo de confianza.</p>
            
            <div style='background: #F8FAFC; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                <h3 style='color: #6D28D9; margin-top: 0;'>¿Qué puedes hacer ahora?</h3>
                <ul style='line-height: 1.8;'>
                    <li>📚 Explora nuestro catálogo de cursos</li>
                    <li>🛒 Agrega cursos a tu carrito</li>
                    <li>🎯 Comienza a aprender sin límites</li>
                    <li>✏️ Si eres instructor, crea y vende tus propios cursos</li>
                </ul>
            </div>
            
            <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
            
            <a href='" . BASE_URL . "' style='display: inline-block; background: #6D28D9; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin-top: 10px;'>
                Ir a Learnly
            </a>
        ";
        
        return self::enviar($destinatario, $nombre, $asunto, $mensaje);
    }
    
    /**
     * Enviar email de compra exitosa
     */
    public static function enviarConfirmacionCompra($destinatario, $nombre, $cursoTitulo, $precio, $moneda) {
        $asunto = "¡Compra exitosa! - " . $cursoTitulo;
        
        $mensaje = "
            <h2>¡Gracias por tu compra!</h2>
            <p>Hola <strong>{$nombre}</strong>,</p>
            <p>Tu compra ha sido procesada exitosamente.</p>
            
            <div style='background: #F8FAFC; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                <h3 style='color: #2563EB; margin-top: 0;'>Detalles de la compra:</h3>
                <p><strong>Curso:</strong> {$cursoTitulo}</p>
                <p><strong>Precio:</strong> {$moneda} {$precio}</p>
            </div>
            
            <p>Ya puedes acceder al curso desde tu panel de aprendiz.</p>
            
            <a href='" . BASE_URL . "aprendiz/misCursos' style='display: inline-block; background: #2563EB; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin-top: 10px;'>
                Ver Mis Cursos
            </a>
        ";
        
        return self::enviar($destinatario, $nombre, $asunto, $mensaje);
    }
    
    /**
     * Plantilla HTML base para los emails
     */
    private static function obtenerPlantilla($nombre, $contenido) {
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Learnly</title>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #F8FAFC;'>
            <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #F8FAFC; padding: 20px 0;'>
                <tr>
                    <td align='center'>
                        <!-- Container -->
                        <table width='600' cellpadding='0' cellspacing='0' style='background-color: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);'>
                            
                            <!-- Header -->
                            <tr>
                                <td style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;'>
                                    <h1 style='margin: 0; color: white; font-size: 32px; font-weight: bold;'>Learnly</h1>
                                </td>
                            </tr>
                            
                            <!-- Contenido -->
                            <tr>
                                <td style='padding: 40px 30px;'>
                                    {$contenido}
                                </td>
                            </tr>
                            
                            <!-- Footer -->
                            <tr>
                                <td style='background-color: #F3F4F6; padding: 20px 30px; text-align: center; font-size: 12px; color: #6B7280;'>
                                    <p style='margin: 0 0 10px 0;'>© " . date('Y') . " Learnly. Todos los derechos reservados.</p>
                                    <p style='margin: 0;'>
                                        <a href='" . BASE_URL . "' style='color: #6D28D9; text-decoration: none;'>Inicio</a> | 
                                        <a href='" . BASE_URL . "contacto' style='color: #6D28D9; text-decoration: none;'>Contacto</a> | 
                                        <a href='" . BASE_URL . "ayuda' style='color: #6D28D9; text-decoration: none;'>Ayuda</a>
                                    </p>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";
    }
}
