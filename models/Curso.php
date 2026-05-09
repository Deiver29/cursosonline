<?php
class Curso {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Crear curso
    public function crear($datos) {
        $sql = "INSERT INTO cursos (capacitador_id, categoria_id, titulo, descripcion, idioma, nivel, precio, moneda, imagen_portada) 
                VALUES (:capacitador_id, :categoria_id, :titulo, :descripcion, :idioma, :nivel, :precio, :moneda, :imagen)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':capacitador_id', $datos['capacitador_id']);
        $stmt->bindParam(':categoria_id', $datos['categoria_id']);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':idioma', $datos['idioma']);
        $stmt->bindParam(':nivel', $datos['nivel']);
        $stmt->bindParam(':precio', $datos['precio']);
        $stmt->bindParam(':moneda', $datos['moneda']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Obtener curso por ID con detalles
    public function obtenerPorId($id) {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, u.nombre as capacitador_nombre,
                (SELECT AVG(calificacion) FROM resenas WHERE curso_id = c.id) as calificacion_promedio,
                (SELECT COUNT(*) FROM resenas WHERE curso_id = c.id) as total_resenas
                FROM cursos c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.capacitador_id = u.id
                WHERE c.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Obtener cursos con filtros
    public function obtenerCatalogo($filtros = []) {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, u.nombre as capacitador_nombre,
                (SELECT AVG(calificacion) FROM resenas WHERE curso_id = c.id) as calificacion_promedio
                FROM cursos c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.capacitador_id = u.id
                WHERE c.publicado = 1 AND c.aprobado = 1";
        
        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (c.titulo LIKE :busqueda OR c.descripcion LIKE :busqueda)";
        }
        
        if (!empty($filtros['categoria'])) {
            $sql .= " AND c.categoria_id = :categoria";
        }
        
        if (!empty($filtros['idioma'])) {
            $sql .= " AND c.idioma = :idioma";
        }
        
        if (!empty($filtros['nivel'])) {
            $sql .= " AND c.nivel = :nivel";
        }
        
        if (isset($filtros['precio_min'])) {
            $sql .= " AND c.precio >= :precio_min";
        }
        
        if (isset($filtros['precio_max'])) {
            $sql .= " AND c.precio <= :precio_max";
        }
        
        $sql .= " ORDER BY c.fecha_creacion DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($filtros['busqueda'])) {
            $busqueda = "%{$filtros['busqueda']}%";
            $stmt->bindParam(':busqueda', $busqueda);
        }
        
        if (!empty($filtros['categoria'])) {
            $stmt->bindParam(':categoria', $filtros['categoria']);
        }
        
        if (!empty($filtros['idioma'])) {
            $stmt->bindParam(':idioma', $filtros['idioma']);
        }
        
        if (!empty($filtros['nivel'])) {
            $stmt->bindParam(':nivel', $filtros['nivel']);
        }
        
        if (isset($filtros['precio_min'])) {
            $stmt->bindParam(':precio_min', $filtros['precio_min']);
        }
        
        if (isset($filtros['precio_max'])) {
            $stmt->bindParam(':precio_max', $filtros['precio_max']);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener cursos de un capacitador
    public function obtenerPorCapacitador($capacitador_id) {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre,
                (SELECT AVG(calificacion) FROM resenas WHERE curso_id = c.id) as calificacion_promedio,
                (SELECT COUNT(*) FROM compras WHERE curso_id = c.id) as total_estudiantes
                FROM cursos c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                WHERE c.capacitador_id = :capacitador_id
                ORDER BY c.fecha_creacion DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':capacitador_id', $capacitador_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Actualizar curso
    public function actualizar($id, $datos) {
        $sql = "UPDATE cursos SET 
                categoria_id = :categoria_id,
                titulo = :titulo,
                descripcion = :descripcion,
                idioma = :idioma,
                nivel = :nivel,
                precio = :precio,
                moneda = :moneda,
                imagen_portada = :imagen
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categoria_id', $datos['categoria_id']);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':idioma', $datos['idioma']);
        $stmt->bindParam(':nivel', $datos['nivel']);
        $stmt->bindParam(':precio', $datos['precio']);
        $stmt->bindParam(':moneda', $datos['moneda']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        
        return $stmt->execute();
    }
    
    // Publicar/despublicar curso
    public function cambiarEstadoPublicacion($id, $publicado) {
        $sql = "UPDATE cursos SET publicado = :publicado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':publicado', $publicado);
        
        return $stmt->execute();
    }
    
    // Aprobar/rechazar curso (administrador)
    public function cambiarEstadoAprobacion($id, $aprobado) {
        $sql = "UPDATE cursos SET aprobado = :aprobado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aprobado', $aprobado);
        
        return $stmt->execute();
    }
    
    // Eliminar curso
    public function eliminar($id) {
        $sql = "DELETE FROM cursos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    // Obtener cursos pendientes de aprobación
    public function obtenerPendientesAprobacion() {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, u.nombre as capacitador_nombre
                FROM cursos c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.capacitador_id = u.id
                WHERE c.publicado = 1 AND c.aprobado = 0
                ORDER BY c.fecha_creacion DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
