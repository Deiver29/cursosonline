<?php
class CapacitadorController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] !== 'capacitador' && $_SESSION['usuario_rol'] !== 'administrador')) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }
    
    public function dashboard() {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursos = $cursoModel->obtenerPorCapacitador($_SESSION['usuario_id']);
        
        require_once 'views/capacitador/dashboard.php';
    }
    
    public function misCursos() {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursos = $cursoModel->obtenerPorCapacitador($_SESSION['usuario_id']);
        
        require_once 'views/capacitador/mis-cursos.php';
    }
    
    public function crearCurso() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'capacitador_id' => $_SESSION['usuario_id'],
                'categoria_id' => $_POST['categoria_id'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'idioma' => $_POST['idioma'],
                'nivel' => $_POST['nivel'],
                'precio' => $_POST['precio'],
                'moneda' => $_POST['moneda'],
                'imagen' => $_POST['imagen'] ?? null
            ];
            
            $cursoModel = new Curso();
            $curso_id = $cursoModel->crear($datos);
            
            if ($curso_id) {
                header("Location: " . BASE_URL . "capacitador/editarCurso/" . $curso_id);
                exit;
            } else {
                $error = "Error al crear el curso";
            }
        }
        
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->obtenerTodas();
        
        require_once 'views/capacitador/crear-curso.php';
    }
    
    public function editarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $curso = $cursoModel->obtenerPorId($id);
        
        // Verificar que el curso pertenece al capacitador
        if ($curso['capacitador_id'] != $_SESSION['usuario_id'] && $_SESSION['usuario_rol'] !== 'administrador') {
            header("Location: " . BASE_URL . "capacitador/dashboard");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'categoria_id' => $_POST['categoria_id'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'idioma' => $_POST['idioma'],
                'nivel' => $_POST['nivel'],
                'precio' => $_POST['precio'],
                'moneda' => $_POST['moneda'],
                'imagen' => $_POST['imagen'] ?? $curso['imagen_portada']
            ];
            
            if ($cursoModel->actualizar($id, $datos)) {
                $mensaje = "Curso actualizado correctamente";
                $curso = $cursoModel->obtenerPorId($id);
            }
        }
        
        $categoriaModel = new Categoria();
        $moduloModel = new Modulo();
        
        $categorias = $categoriaModel->obtenerTodas();
        $modulos = $moduloModel->obtenerPorCurso($id);
        
        require_once 'views/capacitador/editar-curso.php';
    }
    
    public function agregarModulo() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'curso_id' => $_POST['curso_id'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'orden' => $_POST['orden']
            ];
            
            $moduloModel = new Modulo();
            $moduloModel->crear($datos);
            
            header("Location: " . BASE_URL . "capacitador/editarCurso/" . $datos['curso_id']);
            exit;
        }
    }
    
    public function agregarLeccion() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url_contenido = $_POST['url_contenido'] ?? '';
            
            // Verificar si se subió un archivo
            if (isset($_FILES['archivo_contenido']) && $_FILES['archivo_contenido']['error'] === UPLOAD_ERR_OK) {
                $url_contenido = $this->subirArchivo($_FILES['archivo_contenido'], $_POST['tipo_contenido']);
            }
            
            $datos = [
                'modulo_id' => $_POST['modulo_id'],
                'titulo' => $_POST['titulo'],
                'contenido' => $_POST['contenido'],
                'tipo_contenido' => $_POST['tipo_contenido'],
                'url_contenido' => $url_contenido,
                'duracion' => $_POST['duracion'],
                'orden' => $_POST['orden']
            ];
            
            $leccionModel = new Leccion();
            $leccionModel->crear($datos);
            
            header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
            exit;
        }
    }
    
    private function subirArchivo($archivo, $tipo_contenido) {
        // Definir carpeta según tipo de contenido
        $carpetas = [
            'video' => 'videos',
            'video_archivo' => 'videos',
            'pdf' => 'documentos',
            'word' => 'documentos',
            'presentacion' => 'documentos',
            'excel' => 'documentos',
            'codigo' => 'recursos',
            'texto' => 'documentos',
            'markdown' => 'documentos',
            'audio' => 'audio',
            'imagen' => 'imagenes',
            'recurso' => 'recursos'
        ];
        
        $carpeta = $carpetas[$tipo_contenido] ?? 'recursos';
        $directorio_destino = __DIR__ . '/../uploads/' . $carpeta . '/';
        
        // Crear directorio si no existe
        if (!is_dir($directorio_destino)) {
            mkdir($directorio_destino, 0755, true);
        }
        
        // Generar nombre único para el archivo
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombre_archivo = uniqid() . '_' . time() . '.' . $extension;
        $ruta_completa = $directorio_destino . $nombre_archivo;
        
        // Validar tamaño (máximo 500MB)
        $tamano_maximo = 500 * 1024 * 1024; // 500MB
        if ($archivo['size'] > $tamano_maximo) {
            throw new Exception('El archivo es demasiado grande. Máximo 500MB.');
        }
        
        // Validar extensiones permitidas
        $extensiones_permitidas = [
            // Videos
            'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm',
            // Documentos
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'md',
            // Imágenes
            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp',
            // Audio
            'mp3', 'wav', 'm4a', 'ogg', 'flac',
            // Comprimidos
            'zip', 'rar', '7z', 'tar', 'gz'
        ];
        
        if (!in_array(strtolower($extension), $extensiones_permitidas)) {
            throw new Exception('Tipo de archivo no permitido.');
        }
        
        // Mover archivo
        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
            // Retornar URL relativa
            return BASE_URL . 'uploads/' . $carpeta . '/' . $nombre_archivo;
        } else {
            throw new Exception('Error al subir el archivo.');
        }
    }
    
    public function publicarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $curso = $cursoModel->obtenerPorId($id);
        
        if ($curso['capacitador_id'] == $_SESSION['usuario_id'] || $_SESSION['usuario_rol'] === 'administrador') {
            $nuevoEstado = $curso['publicado'] ? 0 : 1;
            $cursoModel->cambiarEstadoPublicacion($id, $nuevoEstado);
        }
        
        header("Location: " . BASE_URL . "capacitador/misCursos");
        exit;
    }
    
    public function eliminarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $curso = $cursoModel->obtenerPorId($id);
        
        if ($curso['capacitador_id'] == $_SESSION['usuario_id'] || $_SESSION['usuario_rol'] === 'administrador') {
            $cursoModel->eliminar($id);
        }
        
        header("Location: " . BASE_URL . "capacitador/misCursos");
        exit;
    }
}
