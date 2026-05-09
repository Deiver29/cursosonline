<?php
class AprendizController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] !== 'aprendiz' && $_SESSION['usuario_rol'] !== 'administrador')) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }
    
    public function dashboard() {
        $this->verificarAcceso();
        
        $compraModel = new Compra();
        $cursos = $compraModel->obtenerCursosComprados($_SESSION['usuario_id']);
        
        require_once 'views/aprendiz/dashboard.php';
    }
    
    public function misCursos() {
        $this->verificarAcceso();
        
        $compraModel = new Compra();
        $cursos = $compraModel->obtenerCursosComprados($_SESSION['usuario_id']);
        
        require_once 'views/aprendiz/mis-cursos.php';
    }
    
    public function verCurso($id) {
        $this->verificarAcceso();
        
        // Verificar que el usuario compró el curso
        $compraModel = new Compra();
        if (!$compraModel->verificarCompra($_SESSION['usuario_id'], $id)) {
            header("Location: " . BASE_URL . "aprendiz/dashboard");
            exit;
        }
        
        $cursoModel = new Curso();
        $moduloModel = new Modulo();
        $leccionModel = new Leccion();
        $progresoModel = new Progreso();
        
        $curso = $cursoModel->obtenerPorId($id);
        $modulos = $moduloModel->obtenerPorCurso($id);
        
        // Obtener lecciones de cada módulo con progreso
        foreach ($modulos as &$modulo) {
            $modulo['lecciones'] = $leccionModel->obtenerPorModulo($modulo['id'], $_SESSION['usuario_id']);
        }
        
        $progreso = $progresoModel->obtenerProgresoCurso($_SESSION['usuario_id'], $id);
        
        require_once 'views/aprendiz/ver-curso.php';
    }
    
    public function verLeccion($id) {
        $this->verificarAcceso();
        
        $leccionModel = new Leccion();
        $leccion = $leccionModel->obtenerPorId($id);
        
        if (!$leccion) {
            header("Location: " . BASE_URL . "aprendiz/dashboard");
            exit;
        }
        
        require_once 'views/aprendiz/ver-leccion.php';
    }
    
    public function marcarCompletada() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $leccion_id = $_POST['leccion_id'];
            
            $progresoModel = new Progreso();
            $progresoModel->marcarCompletada($_SESSION['usuario_id'], $leccion_id);
            
            echo json_encode(['success' => true]);
        }
    }
    
    public function perfil() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => $_POST['nombre'],
                'foto' => $_POST['foto'] ?? null,
                'pais' => $_POST['pais'],
                'biografia' => $_POST['biografia'],
                'idioma' => $_POST['idioma']
            ];
            
            $usuarioModel = new Usuario();
            if ($usuarioModel->actualizarPerfil($_SESSION['usuario_id'], $datos)) {
                $_SESSION['usuario_nombre'] = $datos['nombre'];
                $_SESSION['idioma'] = $datos['idioma'];
                $mensaje = "Perfil actualizado correctamente";
            }
        }
        
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        require_once 'views/aprendiz/perfil.php';
    }
}
