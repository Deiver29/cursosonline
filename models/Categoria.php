<?php
class Categoria {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Obtener todas las categorías activas
    public function obtenerTodas() {
        $sql = "SELECT * FROM categorias WHERE activa = 1 ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Obtener categoría por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM categorias WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}
