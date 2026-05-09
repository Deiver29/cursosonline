# 📚 Marketplace Educativo Internacional

Sistema de marketplace educativo tipo Udemy, desarrollado en PHP puro con arquitectura MVC para gestionar cursos, usuarios y aprendizaje en línea.

## 🎯 Características Principales

### Gestión de Usuarios
- ✅ Registro con correo electrónico
- ✅ Inicio y cierre de sesión seguro
- ✅ Selección de idioma preferido (ES, EN, FR, PT, DE)
- ✅ Gestión de perfil (nombre, foto, país, biografía)
- ✅ Tres roles: Aprendiz, Capacitador y Administrador

### Gestión de Cursos
- ✅ Creación y edición de cursos
- ✅ Definición de título, descripción, idioma, categoría y precio
- ✅ Soporte para múltiples monedas (USD, EUR, GBP, MXN, ARS, COP)
- ✅ Organización en módulos y lecciones
- ✅ Contenido: videos, documentos y recursos descargables
- ✅ Publicación y despublicación de cursos

### Catálogo Global
- ✅ Vista de todos los cursos disponibles
- ✅ Búsqueda por nombre, categoría, idioma y capacitador
- ✅ Filtros por precio, idioma y nivel (básico, intermedio, avanzado)
- ✅ Calificaciones y reseñas visibles

### Sistema de Compras
- ✅ Carrito de compras
- ✅ Procesamiento de pagos simulado
- ✅ Registro de compras
- ✅ Acceso inmediato a cursos comprados

### Experiencia de Aprendizaje
- ✅ Visualización de contenido del curso
- ✅ Seguimiento de progreso por lección
- ✅ Marcado de lecciones completadas
- ✅ Barra de progreso visual

### Reseñas y Reputación
- ✅ Sistema de calificación (1-5 estrellas)
- ✅ Comentarios de usuarios
- ✅ Calificación promedio por curso

### Panel de Administración
- ✅ Gestión completa de usuarios
- ✅ Aprobación/rechazo de cursos
- ✅ Eliminación de contenido inapropiado
- ✅ Estadísticas globales del sistema

## 📁 Estructura del Proyecto

```
cursosonline/
│
├── config/                 # Archivos de configuración
│   ├── config.php         # Configuración general
│   └── Database.php       # Conexión a la base de datos
│
├── controllers/           # Controladores MVC
│   ├── HomeController.php
│   ├── AuthController.php
│   ├── AprendizController.php
│   ├── CapacitadorController.php
│   ├── AdminController.php
│   └── CarritoController.php
│
├── models/               # Modelos de datos
│   ├── Usuario.php
│   ├── Curso.php
│   ├── Categoria.php
│   ├── Modulo.php
│   ├── Leccion.php
│   ├── Compra.php
│   ├── Progreso.php
│   ├── Resena.php
│   └── Carrito.php
│
├── views/                # Vistas organizadas por funcionalidad
│   ├── layout/
│   │   └── header.php
│   ├── errors/
│   │   └── 404.php
│   ├── auth/
│   │   ├── login.php
│   │   └── registro.php
│   ├── home/
│   │   ├── index.php
│   │   └── curso.php
│   ├── aprendiz/
│   │   ├── dashboard.php
│   │   ├── mis-cursos.php
│   │   ├── ver-curso.php
│   │   ├── ver-leccion.php
│   │   └── perfil.php
│   ├── capacitador/
│   │   ├── dashboard.php
│   │   ├── mis-cursos.php
│   │   ├── crear-curso.php
│   │   └── editar-curso.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── usuarios.php
│   │   ├── cursos.php
│   │   └── estadisticas.php
│   └── carrito/
│       ├── index.php
│       └── checkout.php
│
├── assets/
│   └── css/
│       └── style.css     # Estilos responsive
│
├── database/
│   └── schema.sql        # Esquema de base de datos
│
├── .htaccess             # Configuración URL amigables
├── index.php             # Punto de entrada
└── README.md             # Documentación
```

## 🗄️ Base de Datos

### Tablas Principales

1. **usuarios** - Almacena información de usuarios
2. **categorias** - Categorías de cursos
3. **cursos** - Información de cursos
4. **modulos** - Módulos de cada curso
5. **lecciones** - Lecciones de cada módulo
6. **compras** - Registro de compras
7. **progreso** - Seguimiento de progreso de aprendizaje
8. **resenas** - Reseñas y calificaciones
9. **carrito** - Carrito de compras temporal

## 🚀 Instalación

### Requisitos Previos

- XAMPP instalado (Apache + MySQL + PHP)
- PHP 7.4 o superior
- MySQL 5.7 o superior

### Pasos de Instalación

1. **Clonar el proyecto en htdocs**
   ```
   El proyecto ya está en: C:\xampp\htdocs\cursosonline
   ```

2. **Crear la base de datos**
   - Abrir phpMyAdmin: http://localhost:8080/phpmyadmin/
   - Crear una base de datos llamada `marketplace`
   - Importar el archivo `database/schema.sql`

3. **Configurar la conexión**
   - Abrir `config/config.php`
   - Verificar las credenciales de la base de datos:
     ```php
     define('DB_HOST', 'localhost:8080');
     define('DB_NAME', 'marketplace');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     ```

4. **Activar mod_rewrite en Apache**
   - Editar `httpd.conf` en XAMPP
   - Descomentar: `LoadModule rewrite_module modules/mod_rewrite.so`
   - Reiniciar Apache

5. **Acceder al sistema**
   ```
   http://localhost:8080/cursosonline/
   ```

## 👤 Usuarios de Prueba

### Administrador
- **Email:** admin@marketplace.com
- **Password:** password

Puedes crear nuevos usuarios desde el formulario de registro.

## 🎨 Diseño Responsive

El sistema está completamente optimizado para:
- 💻 Escritorio (1200px+)
- 📱 Tablet (768px - 1199px)
- 📱 Móvil (320px - 767px)

### Características Responsive
- Menú hamburguesa en móvil
- Grid adaptativo de cursos
- Tablas scrolleables en dispositivos pequeños
- Formularios optimizados para touch
- Imágenes responsive

## 🔐 Seguridad

- ✅ Contraseñas hasheadas con `password_hash()`
- ✅ Prepared statements (PDO) para prevenir SQL injection
- ✅ Validación de sesiones y roles
- ✅ Protección contra XSS
- ✅ Validación de datos de entrada

## 📊 Funcionalidades por Rol

### Aprendiz
- Ver catálogo de cursos
- Buscar y filtrar cursos
- Agregar cursos al carrito
- Realizar compras
- Acceder a cursos comprados
- Ver lecciones y contenido
- Marcar lecciones como completadas
- Ver su progreso
- Dejar reseñas y calificaciones
- Gestionar su perfil

### Capacitador
- Crear nuevos cursos
- Editar información de cursos
- Agregar módulos y lecciones
- Subir contenido (videos, documentos, recursos)
- Publicar/despublicar cursos
- Ver estadísticas de sus cursos
- Gestionar estudiantes inscritos
- Ver calificaciones recibidas

### Administrador
- Gestionar todos los usuarios
- Activar/desactivar usuarios
- Eliminar usuarios
- Aprobar/rechazar cursos publicados
- Eliminar cursos inapropiados
- Ver estadísticas globales:
  - Usuarios por rol
  - Cursos por categoría
  - Ingresos mensuales
- Monitorear actividad del sistema

## 🛠️ Arquitectura MVC

### Modelo (Model)
- Interactúa con la base de datos
- Contiene la lógica de negocio
- Define métodos para CRUD operations

### Vista (View)
- Presenta la información al usuario
- Archivos PHP con HTML
- Separadas por funcionalidad y rol

### Controlador (Controller)
- Recibe peticiones del usuario
- Coordina modelos y vistas
- Maneja la lógica de la aplicación

### Flujo de Ejecución
```
1. Usuario solicita URL
2. .htaccess redirige a index.php
3. index.php analiza la URL
4. Carga el controlador correspondiente
5. Controlador ejecuta el método solicitado
6. Controlador consulta modelos si es necesario
7. Controlador carga la vista con los datos
8. Vista se renderiza al usuario
```

## 🌍 Soporte Multiidioma

El sistema está preparado para manejar múltiples idiomas:
- Español (es)
- English (en)
- Français (fr)
- Português (pt)
- Deutsch (de)

Cada usuario puede seleccionar su idioma preferido en su perfil.

## 💰 Soporte Multimoneda

Monedas soportadas:
- USD - Dólar estadounidense
- EUR - Euro
- GBP - Libra esterlina
- MXN - Peso mexicano
- ARS - Peso argentino
- COP - Peso colombiano

## 📝 Rutas Principales

### Públicas
- `/` - Página principal con catálogo
- `/auth/login` - Iniciar sesión
- `/auth/registro` - Registro de usuarios
- `/home/curso/{id}` - Detalles de un curso

### Aprendiz
- `/aprendiz/dashboard` - Panel del aprendiz
- `/aprendiz/misCursos` - Cursos comprados
- `/aprendiz/verCurso/{id}` - Ver contenido del curso
- `/aprendiz/verLeccion/{id}` - Ver lección específica
- `/aprendiz/perfil` - Editar perfil

### Capacitador
- `/capacitador/dashboard` - Panel del capacitador
- `/capacitador/misCursos` - Gestionar cursos
- `/capacitador/crearCurso` - Crear nuevo curso
- `/capacitador/editarCurso/{id}` - Editar curso

### Administrador
- `/admin/dashboard` - Panel de administración
- `/admin/usuarios` - Gestionar usuarios
- `/admin/cursos` - Gestionar cursos
- `/admin/estadisticas` - Ver estadísticas

### Carrito
- `/carrito` - Ver carrito
- `/carrito/checkout` - Procesar compra

## 🔄 Casos de Uso Implementados

### RF1-RF5: Gestión de Usuarios
✅ Registro completo con validación
✅ Login/Logout seguro
✅ Selección de idioma
✅ Gestión de perfil completa
✅ Asignación de roles

### RF6-RF10: Gestión de Cursos
✅ Creación de cursos por capacitadores
✅ Definición completa de detalles
✅ Subida de contenido multimedia
✅ Organización en módulos/lecciones
✅ Publicación/despublicación

### RF11-RF13: Catálogo Global
✅ Catálogo completo visible
✅ Búsqueda avanzada
✅ Filtros múltiples

### RF14-RF17: Compra de Cursos
✅ Sistema de carrito
✅ Soporte multimoneda
✅ Registro de compras
✅ Acceso inmediato

### RF18-RF20: Experiencia de Aprendizaje
✅ Visualización de contenido
✅ Seguimiento de progreso
✅ Marcado de completado

### RF21-RF23: Reseñas
✅ Sistema de calificación
✅ Comentarios de usuarios
✅ Calificación promedio

### RF24-RF27: Administración
✅ Gestión de usuarios
✅ Aprobación de cursos
✅ Eliminación de contenido
✅ Estadísticas globales

## 🐛 Solución de Problemas

### Error 404 en las rutas
- Verificar que mod_rewrite esté activado
- Comprobar que existe el archivo .htaccess

### Error de conexión a la base de datos
- Verificar que MySQL esté corriendo
- Comprobar credenciales en config.php
- Asegurar que la base de datos `marketplace` existe

### Las imágenes no se muestran
- Verificar la carpeta `uploads/` tenga permisos de escritura
- Comprobar que las URLs de imágenes sean correctas

## 📞 Soporte

Para dudas o problemas técnicos, revisar:
1. Este archivo README.md
2. Comentarios en el código
3. Estructura de la base de datos en schema.sql

## 📄 Licencia

Proyecto educativo para fines universitarios.

## ✨ Características Técnicas

- **Framework:** PHP puro (sin frameworks externos)
- **Arquitectura:** MVC (Model-View-Controller)
- **Base de datos:** MySQL con PDO
- **Frontend:** HTML5, CSS3, JavaScript vanilla
- **Seguridad:** Password hashing, prepared statements
- **Responsive:** Mobile-first design
- **Compatibilidad:** PHP 7.4+, MySQL 5.7+

---

**Desarrollado con ❤️ para educación**
