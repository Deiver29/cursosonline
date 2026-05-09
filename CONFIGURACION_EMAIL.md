# 📧 Configuración de Envío de Emails en XAMPP

Para que el sistema pueda enviar emails automáticamente al registrarse, necesitas configurar el servidor de correo en XAMPP.

## ✅ Opción 1: Usar Gmail (Recomendado para desarrollo)

### Paso 1: Instalar Sendmail en XAMPP

Sendmail ya viene con XAMPP, solo necesitas configurarlo.

### Paso 2: Configurar `php.ini`

1. Abre el archivo: `c:\xampp\php\php.ini`
2. Busca la sección `[mail function]` y configúrala así:

```ini
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = tu-email@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

### Paso 3: Configurar `sendmail.ini`

1. Abre el archivo: `c:\xampp\sendmail\sendmail.ini`
2. Configúralo así:

```ini
[sendmail]

smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=tu-email@gmail.com
auth_password=tu-contraseña-de-aplicacion
force_sender=tu-email@gmail.com
```

### Paso 4: Obtener Contraseña de Aplicación de Gmail

⚠️ **No uses tu contraseña normal de Gmail**

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Ve a **Seguridad**
3. Activa **Verificación en 2 pasos** (si no la tienes)
4. Busca **Contraseñas de aplicaciones**
5. Genera una contraseña para "Correo"
6. Copia esa contraseña (sin espacios) y úsala en `sendmail.ini`

### Paso 5: Reiniciar Apache

1. Abre el Panel de Control de XAMPP
2. Detén Apache
3. Inicia Apache nuevamente

---

## ✅ Opción 2: Usar Mailtrap (Para pruebas - No envía emails reales)

Si solo quieres probar sin enviar emails reales:

### 1. Crea cuenta en Mailtrap

- Ve a: https://mailtrap.io
- Crea una cuenta gratuita

### 2. Configurar `php.ini`

```ini
[mail function]
SMTP=smtp.mailtrap.io
smtp_port=2525
sendmail_from = test@learnly.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

### 3. Configurar `sendmail.ini`

```ini
[sendmail]

smtp_server=smtp.mailtrap.io
smtp_port=2525
error_logfile=error.log
debug_logfile=debug.log
auth_username=tu-usuario-mailtrap
auth_password=tu-password-mailtrap
force_sender=test@learnly.com
```

Obtén las credenciales de tu inbox en Mailtrap.

---

## ✅ Opción 3: Usar servidor SMTP local (Sin internet)

Si no tienes internet o quieres simular sin configurar nada:

### Comentar el envío de email temporalmente

En `controllers/AuthController.php`, comenta la línea:

```php
// Email::enviarBienvenida($datos['email'], $datos['nombre']);
```

Los usuarios se registrarán normalmente pero sin email.

---

## 🧪 Probar que Funciona

Después de configurar, prueba el envío con este archivo:

**Crea:** `c:\xampp\htdocs\cursosonline\test_email.php`

```php
<?php
require_once 'config/config.php';
require_once 'config/Email.php';

$resultado = Email::enviarBienvenida('tu-email-real@gmail.com', 'Prueba Usuario');

if ($resultado) {
    echo "✅ Email enviado correctamente!";
} else {
    echo "❌ Error al enviar email. Revisa la configuración.";
    echo "<br>Revisa: c:\xampp\sendmail\error.log";
}
?>
```

Accede desde: `http://localhost:8080/cursosonline/test_email.php`

---

## 📝 Solución de Problemas

### Error: "Could not connect to SMTP host"

- Verifica que el puerto 587 esté abierto
- Asegúrate que Gmail tiene acceso de aplicaciones menos seguras
- Verifica la contraseña de aplicación

### Error: "Authentication failed"

- Verifica usuario y contraseña en `sendmail.ini`
- Asegúrate de usar contraseña de aplicación, no la contraseña normal

### No llega el email

- Revisa la carpeta de SPAM
- Revisa el archivo: `c:\xampp\sendmail\error.log`
- Con Mailtrap, revisa tu inbox en la web

### Sendmail.exe no funciona

- Verifica que la ruta en php.ini sea correcta
- Reinicia Apache después de cambios
- En Windows puede necesitar ejecutar como administrador

---

## 🚀 Funcionalidades de Email en Learnly

Ya están implementadas:

1. ✅ **Email de Bienvenida** - Al registrarse
2. ✅ **Email de Confirmación de Compra** - Al comprar un curso

### Usar el email de compra

En `controllers/CarritoController.php`, después de procesar la compra:

```php
Email::enviarConfirmacionCompra(
    $usuario['email'],
    $usuario['nombre'],
    $curso['titulo'],
    $precio,
    $moneda
);
```

---

## 💡 Recomendaciones

- **Desarrollo Local**: Usa Mailtrap (no envía emails reales)
- **Producción**: Usa un servicio profesional como SendGrid, Mailgun, etc.
- **Gmail**: Solo para pruebas, tiene límite de 500 emails/día
- **Seguridad**: Nunca subas credenciales a GitHub

---

¿Necesitas ayuda? Revisa los logs en `c:\xampp\sendmail\error.log`
