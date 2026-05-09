# 📤 Sistema de Carga de Archivos Implementado

## ✨ ¿Qué se implementó?

Ahora puedes **subir archivos directamente desde tu computador** al crear lecciones en tus cursos. Ya no necesitas usar solo URLs externas.

---

## 🎯 Funcionalidades

### Opciones de Contenido

Cuando agregas una lección, ahora tienes **2 opciones**:

1. **🔗 Usar URL Externa**
   - YouTube, Vimeo
   - Google Drive, Dropbox
   - Cualquier enlace público

2. **📤 Subir Archivo desde tu PC**
   - Videos que grabes tú mismo
   - PDFs que crees
   - Presentaciones PowerPoint
   - Archivos de audio
   - Código fuente
   - Cualquier material educativo

---

## 📁 Archivos Soportados

### Videos
- `.mp4`, `.mov`, `.avi`, `.wmv`, `.flv`, `.mkv`, `.webm`
- **Tamaño máximo**: 500MB por archivo

### Documentos
- `.pdf` - PDFs
- `.doc`, `.docx` - Word
- `.ppt`, `.pptx` - PowerPoint
- `.xls`, `.xlsx` - Excel
- `.txt` - Texto plano
- `.md` - Markdown

### Multimedia
- `.mp3`, `.wav`, `.m4a`, `.ogg`, `.flac` - Audio
- `.jpg`, `.jpeg`, `.png`, `.gif`, `.svg`, `.webp` - Imágenes

### Otros
- `.zip`, `.rar`, `.7z`, `.tar`, `.gz` - Archivos comprimidos (código fuente)

---

## ⚙️ Configuración Necesaria

### IMPORTANTE: Aumentar Límites de PHP

Para poder subir archivos grandes (especialmente videos), necesitas ajustar `php.ini`:

1. **Abre** `c:\xampp\php\php.ini`

2. **Busca y modifica estas líneas** (aproximadamente línea 800-900):

```ini
; Tamaño máximo de archivos subidos (500MB)
upload_max_filesize = 500M

; Tamaño máximo del POST (debe ser mayor o igual a upload_max_filesize)
post_max_size = 550M

; Tiempo máximo de ejecución (10 minutos para videos grandes)
max_execution_time = 600

; Memoria máxima (para procesar archivos grandes)
memory_limit = 512M

; Tiempo máximo para recibir datos de entrada
max_input_time = 600
```

3. **Guarda el archivo**

4. **Reinicia Apache** en el panel de XAMPP (Stop y luego Start)

---

## 📂 Estructura de Carpetas

Los archivos se guardan organizadamente en:

```
cursosonline/
└── uploads/
    ├── videos/         ← Videos (.mp4, .mov, etc.)
    ├── documentos/     ← PDFs, Word, Excel, PowerPoint
    ├── imagenes/       ← Imágenes (.jpg, .png, etc.)
    ├── audio/          ← Archivos de audio (.mp3, .wav)
    └── recursos/       ← Código fuente, archivos comprimidos
```

---

## 🎓 Cómo Usar

### Paso 1: Crear/Editar Curso
- Ve a **Capacitador → Editar Curso**

### Paso 2: Agregar Módulo
- Crea un módulo para organizar tu contenido

### Paso 3: Agregar Lección

1. Haz clic en **➕ Agregar Lección**

2. Llena el **Título de la Lección**

3. Selecciona el **Tipo de Contenido**:
   - 📹 Video Archivo (si vas a subir tu propio video)
   - 📄 PDF (si vas a subir un PDF)
   - etc.

4. **Elige cómo agregar el contenido**:
   
   **Opción A: URL Externa**
   - Selecciona "🔗 Usar URL Externa"
   - Pega el enlace (YouTube, Google Drive, etc.)
   
   **Opción B: Subir desde tu PC**
   - Selecciona "📤 Subir Archivo desde mi PC"
   - Haz clic en "Selecciona el Archivo"
   - Elige el archivo de tu computador
   - Verás un preview con el nombre y tamaño del archivo

5. Completa los demás campos (Descripción, Duración, Orden)

6. Haz clic en **Guardar Lección**

---

## 🔒 Seguridad

### Archivos Protegidos
- La carpeta `uploads` tiene protección contra ejecución de PHP
- Solo se permiten extensiones de archivo válidas
- Tamaño máximo: 500MB por archivo
- Los archivos se renombran automáticamente para evitar conflictos

### Nombres de Archivo
- Se genera un nombre único automáticamente
- Formato: `{uniqid}_{timestamp}.{extension}`
- Ejemplo: `65f3a2b1c_1710345678.mp4`

---

## 💡 Ejemplos de Uso

### Ejemplo 1: Video Propio
```
Título: Introducción al Curso
Tipo: 📹 Video Archivo
Método: 📤 Subir Archivo
Archivo: mi_introduccion.mp4 (125 MB)
Duración: 15 minutos
```

### Ejemplo 2: PDF Creado por Ti
```
Título: Guía de Estudio
Tipo: 📄 PDF
Método: 📤 Subir Archivo
Archivo: guia_estudio.pdf (5 MB)
Duración: 0 minutos
```

### Ejemplo 3: Video de YouTube
```
Título: Tutorial Externo
Tipo: 🎥 Video (YouTube)
Método: 🔗 Usar URL Externa
URL: https://www.youtube.com/watch?v=ABC123
Duración: 20 minutos
```

---

## ⚡ Ventajas

✅ **Contenido Exclusivo**: Sube videos que solo tú tienes  
✅ **Sin Dependencias**: No necesitas YouTube o Google Drive  
✅ **Control Total**: Los archivos están en tu servidor  
✅ **Privacidad**: Solo los estudiantes que compraron el curso pueden acceder  
✅ **Rapidez**: No hay procesos de codificación de terceros  
✅ **Organización**: Todo centralizado en tu plataforma  

---

## ⚠️ Limitaciones

- **Tamaño máximo**: 500MB por archivo
  - Para videos más grandes, usa YouTube o Vimeo
  
- **Espacio en disco**: Los archivos ocupan espacio en tu servidor
  - Monitorea el espacio disponible en `c:\xampp\htdocs\cursosonline\uploads`
  
- **Ancho de banda**: Los estudiantes descargan directamente de tu servidor
  - Para muchos estudiantes, considera usar CDN o servicios de video

---

## 🔧 Solución de Problemas

### Error: "El archivo es demasiado grande"
**Solución**: Aumenta `upload_max_filesize` y `post_max_size` en php.ini

### Error: "Tipo de archivo no permitido"
**Solución**: Verifica que la extensión del archivo esté en la lista de permitidas

### Error: "Error al subir el archivo"
**Posibles causas**:
- Permisos insuficientes en la carpeta `uploads`
- Apache no se reinició después de cambiar php.ini
- Tiempo de ejecución agotado (aumenta `max_execution_time`)

### El archivo no se guarda
1. Verifica que exista la carpeta `uploads`
2. Verifica permisos de escritura
3. Revisa logs de PHP en `c:\xampp\php\logs\php_error_log`

---

## 📊 Verificar Configuración Actual

Crea un archivo `info.php` en la raíz del proyecto:

```php
<?php
phpinfo();
?>
```

Ábrelo en: `http://localhost:8080/cursosonline/info.php`

Busca estas configuraciones:
- `upload_max_filesize`
- `post_max_size`
- `max_execution_time`
- `memory_limit`

**IMPORTANTE**: Elimina `info.php` después de verificar (seguridad)

---

## 🎉 Conclusión

Ahora tu plataforma Learnly soporta:

✅ Subida de archivos desde el PC  
✅ URLs externas (YouTube, Google Drive, etc.)  
✅ 50+ idiomas  
✅ 14 tipos de contenido  
✅ Sistema de emails funcionando  

**¡Tu plataforma educativa está completa y lista para usar!** 🚀

---

**Siguiente paso**: Configura `php.ini` siguiendo las instrucciones arriba y prueba subir tu primer video.
