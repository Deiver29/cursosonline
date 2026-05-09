<?php
class AdminController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'administrador') {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }
    
    public function dashboard() {
        $this->verificarAcceso();
        
        // Obtener estadísticas
        $db = Database::getInstance()->getConnection();
        
        // Total de usuarios
        $stmt = $db->query("SELECT COUNT(*) as total FROM usuarios");
        $totalUsuarios = $stmt->fetch()['total'];
        
        // Total de cursos
        $stmt = $db->query("SELECT COUNT(*) as total FROM cursos");
        $totalCursos = $stmt->fetch()['total'];
        
        // Total de compras
        $stmt = $db->query("SELECT COUNT(*) as total FROM compras WHERE estado = 'completado'");
        $totalCompras = $stmt->fetch()['total'];
        
        // Cursos pendientes
        $cursoModel = new Curso();
        $cursosPendientes = $cursoModel->obtenerPendientesAprobacion();
        
        require_once 'views/admin/dashboard.php';
    }
    
    public function usuarios() {
        $this->verificarAcceso();
        
        $usuarioModel = new Usuario();
        $filtro = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $usuarios = $usuarioModel->obtenerTodos($filtro);
        
        require_once 'views/admin/usuarios.php';
    }
    
    public function cambiarEstadoUsuario() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['usuario_id'];
            $activo = $_POST['activo'];
            
            $usuarioModel = new Usuario();
            $usuarioModel->cambiarEstado($id, $activo);
            
            echo json_encode(['success' => true]);
        }
    }
    
    public function eliminarUsuario($id) {
        $this->verificarAcceso();
        
        $usuarioModel = new Usuario();
        $usuarioModel->eliminar($id);
        
        header("Location: " . BASE_URL . "admin/usuarios");
        exit;
    }
    
    public function cursos() {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursosPendientes = $cursoModel->obtenerPendientesAprobacion();
        
        require_once 'views/admin/cursos.php';
    }
    
    public function aprobarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursoModel->cambiarEstadoAprobacion($id, 1);
        
        header("Location: " . BASE_URL . "admin/cursos");
        exit;
    }
    
    public function rechazarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursoModel->cambiarEstadoAprobacion($id, 0);
        
        header("Location: " . BASE_URL . "admin/cursos");
        exit;
    }
    
    public function eliminarCurso($id) {
        $this->verificarAcceso();
        
        $cursoModel = new Curso();
        $cursoModel->eliminar($id);
        
        header("Location: " . BASE_URL . "admin/cursos");
        exit;
    }
    
    public function estadisticas() {
        $this->verificarAcceso();
        
        $db = Database::getInstance()->getConnection();
        
        // Estadísticas generales
        $stats = [];
        
        // Usuarios por rol
        $stmt = $db->query("SELECT rol, COUNT(*) as total FROM usuarios GROUP BY rol");
        $stats['usuarios_por_rol'] = $stmt->fetchAll();
        
        // Cursos por categoría
        $stmt = $db->query("SELECT cat.nombre, COUNT(*) as total FROM cursos c 
                           INNER JOIN categorias cat ON c.categoria_id = cat.id 
                           GROUP BY cat.id");
        $stats['cursos_por_categoria'] = $stmt->fetchAll();
        
        // Ingresos por mes
        $stmt = $db->query("SELECT DATE_FORMAT(fecha_compra, '%Y-%m') as mes, 
                           SUM(precio_pagado) as total 
                           FROM compras 
                           WHERE estado = 'completado' 
                           GROUP BY mes 
                           ORDER BY mes DESC 
                           LIMIT 12");
        $stats['ingresos_mensuales'] = $stmt->fetchAll();
        
        require_once 'views/admin/estadisticas.php';
    }
}
