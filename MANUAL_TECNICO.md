# 🔧 MANUAL TÉCNICO - Marketplace Educativo

## 📋 Tabla de Contenidos
1. [Arquitectura del Sistema](#arquitectura-del-sistema)
2. [Base de Datos](#base-de-datos)
3. [Modelos (Models)](#modelos-models)
4. [Controladores (Controllers)](#controladores-controllers)
5. [Vistas (Views)](#vistas-views)
6. [Seguridad](#seguridad)
7. [Flujo de Datos](#flujo-de-datos)
8. [API Endpoints](#api-endpoints)
9. [Mantenimiento](#mantenimiento)

---

## Arquitectura del Sistema

### Patrón MVC (Model-View-Controller)

```
┌─────────────┐
│   Usuario   │
└──────┬──────┘
       │
       ▼
┌─────────────────┐
│  index.php      │  ← Punto de entrada
│  + .htaccess    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  CONTROLLER     │  ← Lógica de negocio
│  - HomeCtrl     │
│  - AuthCtrl     │
│  - etc.         │
└────┬────────┬───┘
     │        │
     ▼        ▼
┌─────────┐ ┌──────────┐
│  MODEL  │ │   VIEW   │
│ Usuario │ │ Templates│
│  Curso  │ │   HTML   │
│  etc.   │ │   CSS    │
└────┬────┘ └──────────┘
     │
     ▼
┌─────────────┐
│  DATABASE   │
│   MySQL     │
└─────────────┘
```

### Componentes Principales

#### 1. Front Controller (index.php)
```php
// Autoload de clases
spl_autoload_register()

// Parse de URL
$url = $_GET['url']
$url = explode('/', $url)

// Routing
$controller = $url[0] . 'Controller'
$method = $url[1]
$params = array_slice($url, 2)

// Ejecución
$controller->$method(...$params)
```

#### 2. Database Singleton
```php
class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

#### 3. URL Rewriting (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

---

## Base de Datos

### Diagrama ER (Entidad-Relación)

```
┌──────────┐       ┌──────────┐       ┌──────────┐
│ USUARIOS │──1:N──│  CURSOS  │──N:1──│CATEGORIAS│
└────┬─────┘       └────┬─────┘       └──────────┘
     │                  │
     │ 1:N              │ 1:N
     │                  │
     ▼                  ▼
┌──────────┐       ┌──────────┐
│ COMPRAS  │       │ MODULOS  │
└──────────┘       └────┬─────┘
                        │ 1:N
                        ▼
                   ┌──────────┐
                   │LECCIONES │
                   └────┬─────┘
                        │ 1:N
                        ▼
                   ┌──────────┐
                   │ PROGRESO │
                   └──────────┘
```

### Tablas Detalladas

#### usuarios
```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    pais VARCHAR(100),
    biografia TEXT,
    idioma_preferido VARCHAR(10) DEFAULT 'es',
    rol ENUM('aprendiz', 'capacitador', 'administrador'),
    activo TINYINT(1) DEFAULT 1,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_rol (rol)
);
```

**Propósito:** Almacenar información de todos los usuarios del sistema.

**Campos clave:**
- `email`: Único, usado para login
- `password`: Hash bcrypt
- `rol`: Define permisos del usuario
- `activo`: Flag para activar/desactivar

#### cursos
```sql
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    capacitador_id INT NOT NULL,
    categoria_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    idioma VARCHAR(10) NOT NULL,
    nivel ENUM('basico', 'intermedio', 'avanzado'),
    precio DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    moneda VARCHAR(3) DEFAULT 'USD',
    imagen_portada VARCHAR(255),
    publicado TINYINT(1) DEFAULT 0,
    aprobado TINYINT(1) DEFAULT 0,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (capacitador_id) REFERENCES usuarios(id),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    INDEX idx_capacitador (capacitador_id),
    INDEX idx_categoria (categoria_id)
);
```

**Propósito:** Información principal de los cursos.

**Estados:**
- `publicado = 0`: Borrador
- `publicado = 1, aprobado = 0`: Pendiente de revisión
- `publicado = 1, aprobado = 1`: Disponible para compra

#### modulos
```sql
CREATE TABLE modulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    orden INT NOT NULL DEFAULT 0,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);
```

**Propósito:** Organizar el contenido del curso en secciones.

#### lecciones
```sql
CREATE TABLE lecciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    contenido TEXT,
    tipo_contenido ENUM('video', 'documento', 'recurso'),
    url_contenido VARCHAR(255),
    duracion INT DEFAULT 0,
    orden INT NOT NULL DEFAULT 0,
    FOREIGN KEY (modulo_id) REFERENCES modulos(id) ON DELETE CASCADE
);
```

**Tipos de contenido:**
- `video`: Lección con video embebido
- `documento`: PDF, presentación, etc.
- `recurso`: Archivo descargable

#### compras
```sql
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    precio_pagado DECIMAL(10, 2) NOT NULL,
    moneda VARCHAR(3),
    metodo_pago VARCHAR(50),
    estado ENUM('pendiente', 'completado', 'cancelado'),
    fecha_compra DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY compra_unica (usuario_id, curso_id)
);
```

**Constraint UNIQUE:** Un usuario solo puede comprar un curso una vez.

#### progreso
```sql
CREATE TABLE progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    leccion_id INT NOT NULL,
    completado TINYINT(1) DEFAULT 0,
    fecha_completado DATETIME,
    UNIQUE KEY progreso_unico (usuario_id, leccion_id)
);
```

**Propósito:** Tracking del avance del estudiante.

#### resenas
```sql
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    calificacion INT CHECK (calificacion >= 1 AND calificacion <= 5),
    comentario TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY resena_unica (usuario_id, curso_id)
);
```

**Validación:** Calificación entre 1 y 5.

---

## Modelos (Models)

### Estructura de un Modelo

```php
class NombreModelo {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function metodo($parametros) {
        $sql = "SELECT ...";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':param', $parametros);
        $stmt->execute();
        return $stmt->fetch();
    }
}
```

### Métodos Comunes

#### Usuario.php
```php
// Registro
public function registrar($datos)
// Login
public function login($email, $password)
// Obtener por ID
public function obtenerPorId($id)
// Actualizar perfil
public function actualizarPerfil($id, $datos)
// Obtener todos (admin)
public function obtenerTodos($filtro = '')
```

#### Curso.php
```php
// CRUD básico
public function crear($datos)
public function obtenerPorId($id)
public function actualizar($id, $datos)
public function eliminar($id)

// Búsqueda y filtros
public function obtenerCatalogo($filtros = [])
public function obtenerPorCapacitador($capacitador_id)

// Estados
public function cambiarEstadoPublicacion($id, $publicado)
public function cambiarEstadoAprobacion($id, $aprobado)
```

#### Compra.php
```php
// Registrar compra
public function registrar($datos)
// Verificar si ya compró
public function verificarCompra($usuario_id, $curso_id)
// Obtener cursos comprados
public function obtenerCursosComprados($usuario_id)
```

#### Progreso.php
```php
// Marcar como completada
public function marcarCompletada($usuario_id, $leccion_id)
// Obtener progreso del curso
public function obtenerProgresoCurso($usuario_id, $curso_id)
```

### Prepared Statements

**Siempre usar prepared statements para prevenir SQL Injection:**

```php
// ❌ MAL - Vulnerable a SQL Injection
$sql = "SELECT * FROM usuarios WHERE email = '$email'";

// ✅ BIEN - Seguro
$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $this->db->prepare($sql);
$stmt->bindParam(':email', $email);
```

---

## Controladores (Controllers)

### Estructura de un Controlador

```php
class NombreController {
    
    // Verificar acceso (si es necesario)
    private function verificarAcceso() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }
    
    // Método público accesible por URL
    public function metodo($param1 = null) {
        $this->verificarAcceso();
        
        // Lógica del controlador
        $modelo = new Modelo();
        $datos = $modelo->obtener($param1);
        
        // Cargar vista
        require_once 'views/carpeta/archivo.php';
    }
}
```

### Controladores Principales

#### AuthController
```php
// Login
public function login()
// Registro
public function registro()
// Logout
public function logout()
```

#### HomeController
```php
// Catálogo de cursos
public function index()
// Detalle de curso
public function curso($id)
```

#### AprendizController
```php
// Dashboard del aprendiz
public function dashboard()
// Ver cursos comprados
public function misCursos()
// Ver contenido del curso
public function verCurso($id)
// Ver lección específica
public function verLeccion($id)
// Marcar lección completada (AJAX)
public function marcarCompletada()
```

#### CapacitadorController
```php
// Dashboard del capacitador
public function dashboard()
// Crear nuevo curso
public function crearCurso()
// Editar curso existente
public function editarCurso($id)
// Agregar módulo (POST)
public function agregarModulo()
// Agregar lección (POST)
public function agregarLeccion()
// Publicar/despublicar
public function publicarCurso($id)
```

#### AdminController
```php
// Dashboard admin
public function dashboard()
// Gestionar usuarios
public function usuarios()
// Gestionar cursos
public function cursos()
// Ver estadísticas
public function estadisticas()
// Aprobar curso
public function aprobarCurso($id)
// Rechazar curso
public function rechazarCurso($id)
```

---

## Vistas (Views)

### Sistema de Templates

#### Layout Principal (header.php)
```php
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo ?? SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <header class="header">
        <!-- Navegación -->
    </header>
    
    <main>
        <?php echo $contenido ?? ''; ?>
    </main>
    
    <footer class="footer">
        <!-- Footer -->
    </footer>
</body>
</html>
```

#### Vista Individual
```php
<?php ob_start(); ?>

<!-- Contenido de la vista -->
<div class="container">
    <h1><?php echo $titulo; ?></h1>
    <!-- Más contenido -->
</div>

<?php
$contenido = ob_get_clean();
include 'views/layout/header.php';
?>
```

### Organización de Vistas

```
views/
├── layout/
│   └── header.php          # Template principal
├── errors/
│   └── 404.php            # Página de error
├── auth/
│   ├── login.php          # Login
│   └── registro.php       # Registro
├── home/
│   ├── index.php          # Catálogo
│   └── curso.php          # Detalle curso
├── aprendiz/
│   ├── dashboard.php      # Panel aprendiz
│   ├── mis-cursos.php     # Cursos comprados
│   ├── ver-curso.php      # Contenido curso
│   ├── ver-leccion.php    # Lección individual
│   └── perfil.php         # Perfil
├── capacitador/
│   ├── dashboard.php      # Panel capacitador
│   ├── mis-cursos.php     # Gestión cursos
│   ├── crear-curso.php    # Crear curso
│   └── editar-curso.php   # Editar curso
├── admin/
│   ├── dashboard.php      # Panel admin
│   ├── usuarios.php       # Gestión usuarios
│   ├── cursos.php         # Gestión cursos
│   └── estadisticas.php   # Estadísticas
└── carrito/
    ├── index.php          # Ver carrito
    └── checkout.php       # Procesar pago
```

---

## Seguridad

### 1. Autenticación

#### Hash de Contraseñas
```php
// Al registrar
$hash = password_hash($password, PASSWORD_DEFAULT);

// Al validar
if (password_verify($password, $hash)) {
    // Login exitoso
}
```

### 2. Autorización

#### Verificación de Roles
```php
private function verificarAcceso() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: " . BASE_URL . "auth/login");
        exit;
    }
    
    if ($_SESSION['usuario_rol'] !== 'aprendiz') {
        header("HTTP/1.0 403 Forbidden");
        exit;
    }
}
```

### 3. Prevención de SQL Injection

```php
// ✅ Siempre usar prepared statements
$stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
$stmt->bindParam(':email', $email);
```

### 4. Prevención de XSS

```php
// ✅ Escapar output
echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8');
```

### 5. CSRF Protection (Futuro)

```php
// Generar token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Verificar token
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('CSRF token inválido');
}
```

### 6. Validación de Entrada

```php
// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Email inválido";
}

// Sanitizar strings
$nombre = filter_var($nombre, FILTER_SANITIZE_STRING);

// Validar números
$id = filter_var($id, FILTER_VALIDATE_INT);
```

---

## Flujo de Datos

### Flujo de Login

```
1. Usuario envía formulario
   ↓
2. AuthController::login()
   ↓
3. Usuario::login($email, $password)
   ↓
4. Query a base de datos
   ↓
5. password_verify($password, $hash)
   ↓
6. Si es válido:
   - Crear sesión
   - Almacenar datos en $_SESSION
   - Redirigir según rol
   ↓
7. Si es inválido:
   - Mostrar error
   - Volver a vista login
```

### Flujo de Compra

```
1. Usuario agrega curso al carrito
   ↓
2. CarritoController::agregar()
   ↓
3. Carrito::agregar($usuario_id, $curso_id)
   ↓
4. INSERT en tabla carrito
   ↓
5. Usuario va a checkout
   ↓
6. CarritoController::checkout()
   ↓
7. Usuario confirma compra
   ↓
8. Para cada curso en carrito:
   - Compra::registrar()
   - INSERT en tabla compras
   ↓
9. Carrito::vaciar($usuario_id)
   ↓
10. DELETE carrito del usuario
    ↓
11. Redirigir a "Mis Cursos"
```

### Flujo de Creación de Curso

```
1. Capacitador llena formulario
   ↓
2. CapacitadorController::crearCurso()
   ↓
3. Curso::crear($datos)
   ↓
4. INSERT en tabla cursos
   ↓
5. Obtener ID del curso creado
   ↓
6. Redirigir a editarCurso($id)
   ↓
7. Capacitador agrega módulos
   ↓
8. CapacitadorController::agregarModulo()
   ↓
9. Modulo::crear($datos)
   ↓
10. Capacitador agrega lecciones
    ↓
11. CapacitadorController::agregarLeccion()
    ↓
12. Leccion::crear($datos)
    ↓
13. Capacitador publica curso
    ↓
14. Curso::cambiarEstadoPublicacion($id, 1)
    ↓
15. UPDATE cursos SET publicado = 1
```

---

## API Endpoints

### Rutas del Sistema

#### Públicas
```
GET  /                          → HomeController::index()
GET  /home/curso/{id}           → HomeController::curso($id)
GET  /auth/login                → AuthController::login()
POST /auth/login                → AuthController::login()
GET  /auth/registro             → AuthController::registro()
POST /auth/registro             → AuthController::registro()
GET  /auth/logout               → AuthController::logout()
```

#### Aprendiz (Requiere autenticación)
```
GET  /aprendiz/dashboard        → AprendizController::dashboard()
GET  /aprendiz/misCursos        → AprendizController::misCursos()
GET  /aprendiz/verCurso/{id}    → AprendizController::verCurso($id)
GET  /aprendiz/verLeccion/{id}  → AprendizController::verLeccion($id)
POST /aprendiz/marcarCompletada → AprendizController::marcarCompletada()
GET  /aprendiz/perfil           → AprendizController::perfil()
POST /aprendiz/perfil           → AprendizController::perfil()
```

#### Capacitador (Requiere autenticación)
```
GET  /capacitador/dashboard     → CapacitadorController::dashboard()
GET  /capacitador/misCursos     → CapacitadorController::misCursos()
GET  /capacitador/crearCurso    → CapacitadorController::crearCurso()
POST /capacitador/crearCurso    → CapacitadorController::crearCurso()
GET  /capacitador/editarCurso/{id} → CapacitadorController::editarCurso($id)
POST /capacitador/editarCurso/{id} → CapacitadorController::editarCurso($id)
POST /capacitador/agregarModulo → CapacitadorController::agregarModulo()
POST /capacitador/agregarLeccion → CapacitadorController::agregarLeccion()
GET  /capacitador/publicarCurso/{id} → CapacitadorController::publicarCurso($id)
GET  /capacitador/eliminarCurso/{id} → CapacitadorController::eliminarCurso($id)
```

#### Administrador (Requiere autenticación)
```
GET  /admin/dashboard           → AdminController::dashboard()
GET  /admin/usuarios            → AdminController::usuarios()
POST /admin/cambiarEstadoUsuario → AdminController::cambiarEstadoUsuario()
GET  /admin/eliminarUsuario/{id} → AdminController::eliminarUsuario($id)
GET  /admin/cursos              → AdminController::cursos()
GET  /admin/aprobarCurso/{id}   → AdminController::aprobarCurso($id)
GET  /admin/rechazarCurso/{id}  → AdminController::rechazarCurso($id)
GET  /admin/eliminarCurso/{id}  → AdminController::eliminarCurso($id)
GET  /admin/estadisticas        → AdminController::estadisticas()
```

#### Carrito
```
GET  /carrito                   → CarritoController::index()
POST /carrito/agregar           → CarritoController::agregar()
POST /carrito/eliminar          → CarritoController::eliminar()
GET  /carrito/checkout          → CarritoController::checkout()
POST /carrito/checkout          → CarritoController::checkout()
```

---

## Mantenimiento

### Backup de Base de Datos

```bash
# Crear backup
mysqldump -u root -p marketplace > backup_$(date +%Y%m%d).sql

# Restaurar backup
mysql -u root -p marketplace < backup_20240515.sql
```

### Logs de Errores

Activar en producción:
```php
// config.php
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'logs/php-error.log');
```

### Optimización de Base de Datos

```sql
-- Analizar tablas
ANALYZE TABLE usuarios, cursos, compras;

-- Optimizar tablas
OPTIMIZE TABLE usuarios, cursos, compras;

-- Ver tamaño de tablas
SELECT 
    table_name AS 'Tabla',
    round(((data_length + index_length) / 1024 / 1024), 2) AS 'Tamaño (MB)'
FROM information_schema.TABLES 
WHERE table_schema = 'marketplace'
ORDER BY (data_length + index_length) DESC;
```

### Limpieza de Datos

```sql
-- Eliminar carritos antiguos (más de 30 días)
DELETE FROM carrito 
WHERE fecha_agregado < DATE_SUB(NOW(), INTERVAL 30 DAY);

-- Eliminar sesiones expiradas
DELETE FROM sesiones 
WHERE fecha_expiracion < NOW();
```

---

## Extensiones Futuras

### Funcionalidades a Implementar

1. **Sistema de Certificados**
   - Generar certificados PDF al completar curso
   - Verificación de autenticidad

2. **Chat en Vivo**
   - Soporte en tiempo real
   - Chat entre estudiante-instructor

3. **Notificaciones**
   - Email notifications
   - Notificaciones push

4. **Sistema de Cupones**
   - Descuentos
   - Promociones

5. **API REST**
   - Endpoints JSON
   - Aplicación móvil

6. **Analytics Avanzado**
   - Google Analytics
   - Métricas personalizadas

---

**Desarrollado con ❤️ para educación**
