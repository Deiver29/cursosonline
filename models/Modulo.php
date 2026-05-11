<?php
class Modulo {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Crear módulo
    public function crear($datos) {
        $sql = "INSERT INTO modulos (curso_id, titulo, descripcion, orden) 
                VALUES (:curso_id, :titulo, :descripcion, :orden)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':curso_id', $datos['curso_id']);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':orden', $datos['orden']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Obtener módulos de un curso
    public function obtenerPorCurso($curso_id) {
        $sql = "SELECT * FROM modulos WHERE curso_id = :curso_id ORDER BY orden ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':curso_id', $curso_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Obtener módulo por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM modulos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Actualizar módulo
    public function actualizar($id, $datos) {
        $sql = "UPDATE modulos SET 
                titulo = :titulo,
                descripcion = :descripcion,
                orden = :orden
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':orden', $datos['orden']);
        
        return $stmt->execute();
    }
    
    // Eliminar módulo
    public function eliminar($id) {
        $sql = "DELETE FROM modulos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
