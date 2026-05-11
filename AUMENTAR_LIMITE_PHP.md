# 📤 Cómo Aumentar el Límite de Subida de Archivos en PHP

## 🎯 Problema
Al intentar subir videos grandes, aparece el error:
> **Error: El archivo es demasiado grande. El límite actual de PHP es 40M**

## ✅ Solución Rápida

### Paso 1: Editar php.ini

1. **Abre el archivo de configuración de PHP:**
   - Ruta: `c:\xampp\php\php.ini`
   - Usa un editor de texto (Notepad++, VS Code, etc.)

2. **Busca y modifica estas 3 líneas:**

```ini
upload_max_filesize = 500M
post_max_size = 550M
max_execution_time = 600
```

**Explicación:**
- `upload_max_filesize`: Tamaño máximo de un archivo individual (500MB)
- `post_max_size`: Tamaño total de datos POST (debe ser mayor que upload_max_filesize)
- `max_execution_time`: Tiempo máximo en segundos para procesar (10 minutos)

### Paso 2: Reiniciar Apache

1. Abre el **Panel de Control de XAMPP**
2. Haz clic en **Stop** en Apache
3. Espera 2 segundos
4. Haz clic en **Start** en Apache

### Paso 3: Verificar los Cambios

Accede a esta URL para verificar:
```
http://localhost:8080/cursosonline/verificar_limites.php
```

## 📊 Valores Recomendados por Tipo de Contenido

### Para Videos Educativos (Recomendado)
```ini
upload_max_filesize = 500M
post_max_size = 550M
max_execution_time = 600
max_input_time = 600
memory_limit = 256M
```

### Para Cursos Básicos (Solo PDFs y videos cortos)
```ini
upload_max_filesize = 100M
post_max_size = 110M
max_execution_time = 300
```

### Para Plataforma Profesional (Videos largos)
```ini
upload_max_filesize = 2G
post_max_size = 2200M
max_execution_time = 1800
max_input_time = 1800
memory_limit = 512M
```

## 🔍 Cómo Encontrar las Líneas en php.ini

1. Abre `c:\xampp\php\php.ini`
2. Presiona `Ctrl + F` para buscar
3. Busca uno por uno:
   - `upload_max_filesize`
   - `post_max_size`
   - `max_execution_time`
4. Modifica los valores
5. Guarda el archivo (`Ctrl + S`)

## ⚠️ Consejos Importantes

### ✅ Buenas Prácticas
- El `post_max_size` debe ser **siempre mayor** que `upload_max_filesize`
- Para videos de 1 hora en HD: mínimo 500MB
- Para videos de 4K: 1-2GB por hora

### ❌ Errores Comunes
- **No reiniciar Apache** después de los cambios
- Editar el archivo incorrecto (hay varios php.ini, usa el de `c:\xampp\php\`)
- Poner valores demasiado grandes sin necesidad (consume recursos)

## 🎬 Optimización de Videos (Opcional)

Si subes videos muy grandes frecuentemente, considera:

1. **Comprimir videos antes de subirlos:**
   - Usa **HandBrake** (gratis)
   - Formato: MP4 con codec H.264
   - Resolución: 1080p es suficiente para cursos

2. **Usar servicios externos:**
   - YouTube (privado/sin listar)
   - Vimeo
   - Cloudflare Stream

3. **Configurar límites realistas:**
   - Para videos de 30 min: 200-300MB
   - Para videos de 1 hora: 400-600MB

## 🧪 Archivo de Verificación

Crea este archivo para verificar tu configuración actual:

**Archivo: `verificar_limites.php`**
```php
<?php
phpinfo();
?>
```

Busca en la página generada:
- `upload_max_filesize`
- `post_max_size`
- `max_execution_time`

## 📞 Soporte Adicional

Si después de estos pasos el error persiste:

1. Verifica que guardaste el archivo php.ini
2. Confirma que reiniciaste Apache
3. Revisa los logs: `c:\xampp\apache\logs\error.log`
4. Prueba con un archivo más pequeño para confirmar que funciona

---

**Última actualización:** Mayo 2026
