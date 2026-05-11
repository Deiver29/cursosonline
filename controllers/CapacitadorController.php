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
        $leccionModel = new Leccion();
        
        $categorias = $categoriaModel->obtenerTodas();
        $modulos = $moduloModel->obtenerPorCurso($id);
        
        // Obtener lecciones de cada módulo
        for ($i = 0; $i < count($modulos); $i++) {
            $modulos[$i]['lecciones'] = $leccionModel->obtenerPorModulo($modulos[$i]['id']);
        }
        
        require_once 'views/capacitador/editar-curso.php';
    }
    
    public function agregarModulo() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Prevenir doble envío
            $token = $_POST['form_token'] ?? '';
            
            if (!empty($token) && isset($_SESSION['processed_tokens']) && in_array($token, $_SESSION['processed_tokens'])) {
                // Este formulario ya fue procesado
                $_SESSION['warning'] = "Este módulo ya fue agregado anteriormente.";
                header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
                exit;
            }
            
            // Verificar si ya existe un módulo con el mismo título en este curso
            $moduloModel = new Modulo();
            $modulosExistentes = $moduloModel->obtenerPorCurso($_POST['curso_id']);
            
            foreach ($modulosExistentes as $mod) {
                if (trim(strtolower($mod['titulo'])) === trim(strtolower($_POST['titulo']))) {
                    $_SESSION['error'] = "Ya existe un módulo con el título '" . htmlspecialchars($_POST['titulo']) . "' en este curso.";
                    header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
                    exit;
                }
            }
            
            $datos = [
                'curso_id' => $_POST['curso_id'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'orden' => $_POST['orden']
            ];
            
            $moduloModel->crear($datos);
            
            // Marcar token como procesado
            if (!isset($_SESSION['processed_tokens'])) {
                $_SESSION['processed_tokens'] = [];
            }
            $_SESSION['processed_tokens'][] = $token;
            
            // Mantener solo los últimos 10 tokens
            if (count($_SESSION['processed_tokens']) > 10) {
                array_shift($_SESSION['processed_tokens']);
            }
            
            $_SESSION['mensaje'] = "Módulo agregado correctamente";
            header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
            exit;
        }
    }
    
    public function agregarLeccion() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar si el POST fue exitoso (no excedió el límite)
            if (empty($_POST) && empty($_FILES)) {
                $_SESSION['error'] = "El archivo es demasiado grande. El límite actual de PHP es " . ini_get('post_max_size') . ". <a href='" . BASE_URL . "verificar_limites.php' target='_blank' style='color: #2563EB; text-decoration: underline;'>Ver instrucciones para aumentar el límite</a>";
                header("Location: " . $_SERVER['HTTP_REFERER'] ?? BASE_URL . "capacitador/dashboard");
                exit;
            }
            
            // Prevenir doble envío
            $token = $_POST['form_token'] ?? '';
            
            if (!empty($token) && isset($_SESSION['processed_tokens']) && in_array($token, $_SESSION['processed_tokens'])) {
                // Este formulario ya fue procesado
                $_SESSION['warning'] = "Esta lección ya fue agregada anteriormente.";
                header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
                exit;
            }
            
            // Verificar si ya existe una lección con el mismo título en este módulo
            $leccionModel = new Leccion();
            $leccionesExistentes = $leccionModel->obtenerPorModulo($_POST['modulo_id']);
            
            foreach ($leccionesExistentes as $lec) {
                if (trim(strtolower($lec['titulo'])) === trim(strtolower($_POST['titulo']))) {
                    $_SESSION['error'] = "Ya existe una lección con el título '" . htmlspecialchars($_POST['titulo']) . "' en este módulo.";
                    header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
                    exit;
                }
            }
            
            try {
                $url_contenido = $_POST['url_contenido'] ?? '';
                
                // Convertir URLs de YouTube/Vimeo al formato embed
                if (!empty($url_contenido)) {
                    $url_contenido = $this->convertirURLVideo($url_contenido);
                }
                
                // Verificar si se subió un archivo
                if (isset($_FILES['archivo_contenido']) && $_FILES['archivo_contenido']['error'] === UPLOAD_ERR_OK) {
                    $url_contenido = $this->subirArchivo($_FILES['archivo_contenido'], $_POST['tipo_contenido']);
                } elseif (isset($_FILES['archivo_contenido']) && $_FILES['archivo_contenido']['error'] !== UPLOAD_ERR_NO_FILE) {
                    // Manejar errores de subida
                    $errores = [
                        UPLOAD_ERR_INI_SIZE => 'El archivo excede el límite de ' . ini_get('upload_max_filesize'),
                        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el límite especificado en el formulario',
                        UPLOAD_ERR_PARTIAL => 'El archivo solo se subió parcialmente',
                        UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
                        UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en disco',
                        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida'
                    ];
                    
                    throw new Exception($errores[$_FILES['archivo_contenido']['error']] ?? 'Error desconocido al subir el archivo');
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
                
                // Marcar token como procesado
                if (!empty($token)) {
                    if (!isset($_SESSION['processed_tokens'])) {
                        $_SESSION['processed_tokens'] = [];
                    }
                    $_SESSION['processed_tokens'][] = $token;
                    
                    // Mantener solo los últimos 10 tokens
                    if (count($_SESSION['processed_tokens']) > 10) {
                        array_shift($_SESSION['processed_tokens']);
                    }
                }
                
                $_SESSION['mensaje'] = "Lección agregada correctamente";
                header("Location: " . BASE_URL . "capacitador/editarCurso/" . $_POST['curso_id']);
                exit;
                
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: " . $_SERVER['HTTP_REFERER'] ?? BASE_URL . "capacitador/dashboard");
                exit;
            }
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
    
    public function eliminarLeccion($leccion_id, $curso_id) {
        $this->verificarAcceso();
        
        $leccionModel = new Leccion();
        $leccion = $leccionModel->obtenerPorId($leccion_id);
        
        if ($leccion) {
            // Si es un archivo subido, eliminarlo del servidor
            if (!empty($leccion['url_contenido']) && strpos($leccion['url_contenido'], BASE_URL . 'uploads/') === 0) {
                $archivo_path = str_replace(BASE_URL, '', $leccion['url_contenido']);
                $archivo_completo = __DIR__ . '/../' . $archivo_path;
                if (file_exists($archivo_completo)) {
                    unlink($archivo_completo);
                }
            }
            
            $leccionModel->eliminar($leccion_id);
        }
        
        header("Location: " . BASE_URL . "capacitador/editarCurso/" . $curso_id);
        exit;
    }
    
    public function eliminarModulo($modulo_id, $curso_id) {
        $this->verificarAcceso();
        
        $moduloModel = new Modulo();
        $leccionModel = new Leccion();
        
        // Obtener lecciones del módulo para eliminar archivos
        $lecciones = $leccionModel->obtenerPorModulo($modulo_id);
        
        foreach ($lecciones as $leccion) {
            // Si es un archivo subido, eliminarlo del servidor
            if (!empty($leccion['url_contenido']) && strpos($leccion['url_contenido'], BASE_URL . 'uploads/') === 0) {
                $archivo_path = str_replace(BASE_URL, '', $leccion['url_contenido']);
                $archivo_completo = __DIR__ . '/../' . $archivo_path;
                if (file_exists($archivo_completo)) {
                    unlink($archivo_completo);
                }
            }
        }
        
        // Eliminar módulo (las lecciones se eliminan en cascada)
        $moduloModel->eliminar($modulo_id);
        
        header("Location: " . BASE_URL . "capacitador/editarCurso/" . $curso_id);
        exit;
    }
    
    /**
     * Convierte URLs de YouTube y Vimeo al formato embed
     */
    private function convertirURLVideo($url) {
        // YouTube - Formatos soportados:
        // https://www.youtube.com/watch?v=VIDEO_ID
        // https://youtu.be/VIDEO_ID
        // https://m.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        
        // Vimeo - Formatos soportados:
        // https://vimeo.com/VIDEO_ID
        // https://player.vimeo.com/video/VIDEO_ID
        if (preg_match('/(?:vimeo\.com\/(?:video\/)?|player\.vimeo\.com\/video\/)(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }
        
        // Si no es YouTube ni Vimeo, devolver la URL original
        return $url;
    }
}

