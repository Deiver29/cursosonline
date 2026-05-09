# 🎓 MANUAL DE USUARIO - Marketplace Educativo

## 📖 Índice
1. [Introducción](#introducción)
2. [Acceso al Sistema](#acceso-al-sistema)
3. [Registro de Usuario](#registro-de-usuario)
4. [Roles y Funcionalidades](#roles-y-funcionalidades)
5. [Guía para Aprendices](#guía-para-aprendices)
6. [Guía para Capacitadores](#guía-para-capacitadores)
7. [Guía para Administradores](#guía-para-administradores)

---

## Introducción

Bienvenido al **Marketplace Educativo Internacional**, una plataforma de aprendizaje en línea donde puedes:
- 📚 Explorar y comprar cursos de todo el mundo
- 👨‍🏫 Crear y vender tus propios cursos
- 🌍 Aprender en múltiples idiomas
- 💰 Pagar en diferentes monedas

---

## Acceso al Sistema

### URL de Acceso
```
http://localhost:8080/cursosonline/
```

### Primera Vez
1. Ingresa a la URL en tu navegador
2. Haz clic en "Registrarse"
3. Completa el formulario de registro
4. Inicia sesión con tus credenciales

### Usuario Administrador Predeterminado
- **Email:** admin@marketplace.com
- **Contraseña:** password

---

## Registro de Usuario

### Pasos para Registrarse

1. **Acceder al Formulario**
   - Clic en "Registrarse" en la página principal

2. **Completar Información**
   - **Nombre completo:** Tu nombre real
   - **Email:** Un correo válido (será tu usuario)
   - **Contraseña:** Mínimo 6 caracteres
   - **País:** Tu país de residencia
   - **Idioma:** Tu idioma preferido
   - **Tipo de usuario:**
     - **Aprendiz:** Para tomar cursos
     - **Capacitador:** Para crear y vender cursos

3. **Confirmar Registro**
   - Clic en "Registrarse"
   - Serás redirigido al login

---

## Roles y Funcionalidades

### 👨‍🎓 Aprendiz (Estudiante)
- Ver catálogo de cursos
- Comprar cursos
- Acceder a cursos comprados
- Ver lecciones y videos
- Marcar progreso
- Dejar reseñas

### 👨‍🏫 Capacitador (Instructor)
- Crear cursos
- Gestionar contenido
- Ver estadísticas
- Recibir calificaciones

### 👨‍💼 Administrador
- Gestionar usuarios
- Aprobar cursos
- Ver estadísticas globales
- Moderar contenido

---

## Guía para Aprendices

### 1. Explorar Cursos

#### Búsqueda y Filtros
1. Ir a la página principal
2. Usar la barra de búsqueda:
   - **Buscar por nombre:** Escribe palabras clave
   - **Filtrar por categoría:** Desarrollo, Diseño, etc.
   - **Filtrar por idioma:** ES, EN, FR, PT, DE
   - **Filtrar por nivel:** Básico, Intermedio, Avanzado
3. Clic en "Buscar"

#### Ver Detalles del Curso
1. Clic en "Ver Curso" en cualquier tarjeta
2. Verás:
   - Descripción completa
   - Contenido del curso (módulos)
   - Precio y moneda
   - Calificación promedio
   - Reseñas de otros usuarios

### 2. Comprar Cursos

#### Agregar al Carrito
1. En la página del curso, clic en "Agregar al Carrito"
2. Puedes seguir agregando más cursos
3. Acceder al carrito desde el icono 🛒

#### Proceso de Compra
1. Ir al carrito (🛒 Carrito)
2. Revisar cursos seleccionados
3. Clic en "Proceder al Pago"
4. Seleccionar método de pago
5. Clic en "Confirmar Compra"
6. Acceso inmediato a tus cursos

### 3. Acceder a Mis Cursos

1. Ir a "Mi Panel" → "Mis Cursos"
2. Ver todos tus cursos comprados
3. Ver barra de progreso de cada curso
4. Clic en "Ver Curso" para acceder

### 4. Tomar un Curso

#### Navegar por el Contenido
1. En "Ver Curso", verás:
   - Menú lateral con módulos y lecciones
   - Barra de progreso general
   - Lista de lecciones

#### Ver una Lección
1. Clic en cualquier lección del menú
2. Verás:
   - Video (si aplica)
   - Contenido escrito
   - Recursos descargables
3. Al terminar, clic en "✓ Marcar como Completada"

#### Seguir tu Progreso
- La barra de progreso se actualiza automáticamente
- Las lecciones completadas aparecen en verde ✓
- Las pendientes aparecen en gris ○

### 5. Dejar Reseñas

1. Ir a la página del curso
2. Scroll hasta "Reseñas"
3. Seleccionar calificación (1-5 estrellas)
4. Escribir comentario
5. Enviar reseña

### 6. Gestionar Perfil

1. Ir a "Mi Panel" → "Mi Perfil"
2. Actualizar:
   - Nombre
   - Foto (URL)
   - País
   - Biografía
   - Idioma preferido
3. Clic en "Actualizar Perfil"

---

## Guía para Capacitadores

### 1. Crear un Curso

#### Paso 1: Información Básica
1. Ir a "Mi Panel" → "Crear Curso"
2. Completar:
   - **Título:** Nombre atractivo del curso
   - **Descripción:** Qué aprenderán los estudiantes
   - **Categoría:** Área temática
   - **Idioma:** Idioma del contenido
   - **Nivel:** Básico, Intermedio o Avanzado
   - **Precio:** Valor del curso
   - **Moneda:** USD, EUR, MXN, etc.
   - **Imagen:** URL de la portada
3. Clic en "Crear Curso"

#### Paso 2: Agregar Contenido
Después de crear el curso, serás redirigido a la página de edición.

##### Agregar Módulos
1. Clic en "➕ Agregar Módulo"
2. Completar:
   - **Título del módulo:** Ej: "Introducción a Python"
   - **Descripción:** Breve descripción
   - **Orden:** Número de orden (1, 2, 3...)
3. Clic en "Guardar Módulo"

##### Agregar Lecciones
1. En cada módulo, clic en "➕ Agregar Lección"
2. Completar:
   - **Título:** Nombre de la lección
   - **Tipo de contenido:**
     - Video: Para lecciones en video
     - Documento: Para PDFs, presentaciones
     - Recurso: Para archivos descargables
   - **URL del contenido:**
     - Para videos: URL de YouTube o Vimeo
     - Para documentos: URL del archivo
   - **Contenido/Descripción:** Texto explicativo
   - **Duración:** En minutos
   - **Orden:** Número de orden
3. Clic en "Guardar Lección"

### 2. Publicar un Curso

#### Estados del Curso
- **Borrador:** No visible para estudiantes
- **Publicado:** Visible pero pendiente de aprobación
- **Aprobado:** Disponible para compra

#### Proceso de Publicación
1. Ir a "Mis Cursos"
2. Localizar tu curso
3. Clic en "Publicar"
4. El curso pasará a estado "Pendiente de aprobación"
5. Un administrador lo revisará
6. Una vez aprobado, estará disponible

### 3. Editar un Curso

1. Ir a "Mis Cursos"
2. Clic en "Editar" en el curso deseado
3. Modificar información
4. Agregar/editar módulos y lecciones
5. Los cambios se guardan automáticamente

### 4. Ver Estadísticas

En tu Dashboard verás:
- Total de cursos creados
- Cursos publicados
- Cursos aprobados
- Total de estudiantes
- Calificaciones promedio por curso

### 5. Gestionar Cursos

#### Despublicar un Curso
1. Ir a "Mis Cursos"
2. Clic en "Despublicar"
3. El curso dejará de ser visible

#### Eliminar un Curso
1. Ir a "Mis Cursos"
2. Clic en "Eliminar"
3. Confirmar acción
4. **Nota:** Esto eliminará todo el contenido

---

## Guía para Administradores

### 1. Panel de Administración

#### Acceso
1. Iniciar sesión como administrador
2. Ir a "Panel Admin"
3. Verás el dashboard con estadísticas

#### Estadísticas Principales
- Total de usuarios
- Total de cursos
- Total de compras
- Cursos pendientes de aprobación

### 2. Gestionar Usuarios

#### Ver Todos los Usuarios
1. Ir a "Usuarios"
2. Verás lista completa con:
   - Nombre
   - Email
   - Rol
   - País
   - Estado (Activo/Inactivo)

#### Buscar Usuarios
1. Usar barra de búsqueda
2. Buscar por nombre o email
3. Clic en "Buscar"

#### Activar/Desactivar Usuarios
1. Localizar usuario
2. Clic en "Desactivar" o "Activar"
3. El usuario no podrá acceder si está inactivo

#### Eliminar Usuarios
1. Localizar usuario
2. Clic en "Eliminar"
3. Confirmar acción
4. **Nota:** Esto eliminará toda su información

### 3. Gestionar Cursos

#### Ver Cursos Pendientes
1. Ir a "Cursos"
2. Verás cursos pendientes de aprobación
3. Por cada curso puedes:
   - Ver detalles
   - Aprobar
   - Rechazar
   - Eliminar

#### Aprobar un Curso
1. Revisar contenido (clic en "Ver")
2. Si cumple las políticas, clic en "Aprobar"
3. El curso estará disponible para compra

#### Rechazar un Curso
1. Si no cumple políticas, clic en "Rechazar"
2. El curso volverá a estado "No aprobado"
3. El capacitador puede editarlo y volver a publicar

#### Eliminar Contenido Inapropiado
1. Si un curso viola políticas, clic en "Eliminar"
2. Confirmar acción
3. El contenido será eliminado permanentemente

### 4. Ver Estadísticas Globales

#### Acceder a Estadísticas
1. Ir a "Estadísticas"
2. Verás tres secciones:

#### Usuarios por Rol
- Cantidad de Aprendices
- Cantidad de Capacitadores
- Cantidad de Administradores

#### Cursos por Categoría
- Distribución de cursos en cada categoría
- Categorías más populares

#### Ingresos Mensuales
- Total de ingresos por mes
- Últimos 12 meses
- Suma total de compras

---

## 💡 Consejos y Mejores Prácticas

### Para Aprendices
- ✅ Completa tu perfil para una mejor experiencia
- ✅ Lee las reseñas antes de comprar
- ✅ Marca tus lecciones completadas para seguir tu progreso
- ✅ Deja reseñas honestas para ayudar a otros

### Para Capacitadores
- ✅ Escribe descripciones claras y detalladas
- ✅ Organiza bien tus módulos y lecciones
- ✅ Usa videos de buena calidad
- ✅ Establece precios competitivos
- ✅ Responde a las reseñas de tus estudiantes

### Para Administradores
- ✅ Revisa regularmente los cursos pendientes
- ✅ Mantén políticas claras de contenido
- ✅ Monitorea las estadísticas frecuentemente
- ✅ Responde a reportes de usuarios

---

## ❓ Preguntas Frecuentes

### ¿Cómo cambio mi contraseña?
Actualmente desde el perfil. En futuras versiones habrá opción de cambio de contraseña.

### ¿Puedo ser Aprendiz y Capacitador?
No en la misma cuenta. Debes crear cuentas separadas con emails diferentes.

### ¿Cómo funciona el sistema de pagos?
Es simulado para fines educativos. En producción se integraría con plataformas reales.

### ¿Puedo descargar los cursos?
No, los cursos se ven en línea. Los recursos marcados como "descargables" sí pueden descargarse.

### ¿Los cursos tienen fecha de caducidad?
No, una vez comprado un curso, tienes acceso de por vida.

### ¿Puedo devolver un curso?
En esta versión no hay sistema de devoluciones. Revisa bien antes de comprar.

---

## 📞 Soporte Técnico

Si encuentras problemas técnicos:
1. Verifica tu conexión a internet
2. Limpia caché del navegador
3. Revisa que XAMPP esté corriendo
4. Consulta la documentación técnica en README.md

---

**¡Disfruta aprendiendo y enseñando! 🎓**
