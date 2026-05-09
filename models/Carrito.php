<?php
class Carrito {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Agregar curso al carrito
    public function agregar($usuario_id, $curso_id) {
        $sql = "INSERT INTO carrito (usuario_id, curso_id) VALUES (:usuario_id, :curso_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':curso_id', $curso_id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false; // Ya existe en el carrito
        }
    }
    
    // Obtener cursos en el carrito
    public function obtenerCursos($usuario_id) {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, u.nombre as capacitador_nombre,
                car.fecha_agregado
                FROM carrito car
                INNER JOIN cursos c ON car.curso_id = c.id
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.capacitador_id = u.id
                WHERE car.usuario_id = :usuario_id
                ORDER BY car.fecha_agregado DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Eliminar curso del carrito
    public function eliminar($usuario_id, $curso_id) {
        $sql = "DELETE FROM carrito WHERE usuario_id = :usuario_id AND curso_id = :curso_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':curso_id', $curso_id);
        
        return $stmt->execute();
    }
    
    // Vaciar carrito
    public function vaciar($usuario_id) {
        $sql = "DELETE FROM carrito WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        
        return $stmt->execute();
    }
    
    // Contar items en carrito
    public function contarItems($usuario_id) {
        $sql = "SELECT COUNT(*) as total FROM carrito WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }
}
