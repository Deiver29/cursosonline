<?php
class HomeController {
    
    public function index() {
        $cursoModel = new Curso();
        $categoriaModel = new Categoria();
        
        // Obtener filtros
        $filtros = [];
        if (isset($_GET['busqueda'])) $filtros['busqueda'] = $_GET['busqueda'];
        if (isset($_GET['categoria'])) $filtros['categoria'] = $_GET['categoria'];
        if (isset($_GET['idioma'])) $filtros['idioma'] = $_GET['idioma'];
        if (isset($_GET['nivel'])) $filtros['nivel'] = $_GET['nivel'];
        if (isset($_GET['precio_min'])) $filtros['precio_min'] = $_GET['precio_min'];
        if (isset($_GET['precio_max'])) $filtros['precio_max'] = $_GET['precio_max'];
        
        $cursos = $cursoModel->obtenerCatalogo($filtros);
        $categorias = $categoriaModel->obtenerTodas();
        
        // Solo mostrar 5 cursos destacados en la portada
        $cursosDestacados = array_slice($cursos, 0, 5);
        
        require_once 'views/home/index.php';
    }
    
    public function curso($id) {
        $cursoModel = new Curso();
        $moduloModel = new Modulo();
        $resenaModel = new Resena();
        
        $curso = $cursoModel->obtenerPorId($id);
        
        if (!$curso) {
            header("Location: " . BASE_URL);
            exit;
        }
        
        $modulos = $moduloModel->obtenerPorCurso($id);
        $resenas = $resenaModel->obtenerPorCurso($id);
        
        // Verificar si el usuario ya compró el curso
        $yaComprado = false;
        if (isset($_SESSION['usuario_id'])) {
            $compraModel = new Compra();
            $yaComprado = $compraModel->verificarCompra($_SESSION['usuario_id'], $id);
        }
        
        require_once 'views/home/curso.php';
    }

    public function catalogo() {
        $cursoModel = new Curso();
        $categoriaModel = new Categoria();

        // Obtener filtros simples (opcional)
        $filtros = [];
        if (isset($_GET['busqueda'])) $filtros['busqueda'] = $_GET['busqueda'];
        if (isset($_GET['categoria'])) $filtros['categoria'] = $_GET['categoria'];
        if (isset($_GET['nivel'])) $filtros['nivel'] = $_GET['nivel'];

        $cursos = $cursoModel->obtenerCatalogo($filtros);
        $categorias = $categoriaModel->obtenerTodas();

        require_once 'views/home/catalogo.php';
    }
}
