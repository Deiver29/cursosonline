<?php
class Leccion {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Crear lección
    public function crear($datos) {
        $sql = "INSERT INTO lecciones (modulo_id, titulo, contenido, tipo_contenido, url_contenido, duracion, orden) 
                VALUES (:modulo_id, :titulo, :contenido, :tipo_contenido, :url_contenido, :duracion, :orden)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modulo_id', $datos['modulo_id']);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':contenido', $datos['contenido']);
        $stmt->bindParam(':tipo_contenido', $datos['tipo_contenido']);
        $stmt->bindParam(':url_contenido', $datos['url_contenido']);
        $stmt->bindParam(':duracion', $datos['duracion']);
        $stmt->bindParam(':orden', $datos['orden']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Obtener lecciones de un módulo
    public function obtenerPorModulo($modulo_id, $usuario_id = null) {
        $sql = "SELECT l.*";
        
        if ($usuario_id) {
            $sql .= ", p.completado, p.fecha_completado";
        }
        
        $sql .= " FROM lecciones l";
        
        if ($usuario_id) {
            $sql .= " LEFT JOIN progreso p ON l.id = p.leccion_id AND p.usuario_id = :usuario_id";
        }
        
        $sql .= " WHERE l.modulo_id = :modulo_id ORDER BY l.orden ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modulo_id', $modulo_id);
        
        if ($usuario_id) {
            $stmt->bindParam(':usuario_id', $usuario_id);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Obtener lección por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM lecciones WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Actualizar lección
    public function actualizar($id, $datos) {
        $sql = "UPDATE lecciones SET 
                titulo = :titulo,
                contenido = :contenido,
                tipo_contenido = :tipo_contenido,
                url_contenido = :url_contenido,
                duracion = :duracion,
                orden = :orden
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':contenido', $datos['contenido']);
        $stmt->bindParam(':tipo_contenido', $datos['tipo_contenido']);
        $stmt->bindParam(':url_contenido', $datos['url_contenido']);
        $stmt->bindParam(':duracion', $datos['duracion']);
        $stmt->bindParam(':orden', $datos['orden']);
        
        return $stmt->execute();
    }
    
    // Eliminar lección
    public function eliminar($id) {
        $sql = "DELETE FROM lecciones WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
