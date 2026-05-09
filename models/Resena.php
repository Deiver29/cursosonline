<?php
class Resena {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Crear reseña
    public function crear($datos) {
        $sql = "INSERT INTO resenas (usuario_id, curso_id, calificacion, comentario) 
                VALUES (:usuario_id, :curso_id, :calificacion, :comentario)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $datos['usuario_id']);
        $stmt->bindParam(':curso_id', $datos['curso_id']);
        $stmt->bindParam(':calificacion', $datos['calificacion']);
        $stmt->bindParam(':comentario', $datos['comentario']);
        
        return $stmt->execute();
    }
    
    // Obtener reseñas de un curso
    public function obtenerPorCurso($curso_id) {
        $sql = "SELECT r.*, u.nombre as usuario_nombre, u.foto as usuario_foto
                FROM resenas r
                INNER JOIN usuarios u ON r.usuario_id = u.id
                WHERE r.curso_id = :curso_id
                ORDER BY r.fecha_creacion DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':curso_id', $curso_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Verificar si un usuario ya reseñó un curso
    public function verificarResena($usuario_id, $curso_id) {
        $sql = "SELECT * FROM resenas WHERE usuario_id = :usuario_id AND curso_id = :curso_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':curso_id', $curso_id);
        $stmt->execute();
        
        return $stmt->fetch() ? true : false;
    }
}
