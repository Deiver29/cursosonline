<?php
class Compra {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Registrar compra
    public function registrar($datos) {
        $sql = "INSERT INTO compras (usuario_id, curso_id, precio_pagado, moneda, metodo_pago, estado) 
                VALUES (:usuario_id, :curso_id, :precio_pagado, :moneda, :metodo_pago, :estado)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $datos['usuario_id']);
        $stmt->bindParam(':curso_id', $datos['curso_id']);
        $stmt->bindParam(':precio_pagado', $datos['precio_pagado']);
        $stmt->bindParam(':moneda', $datos['moneda']);
        $stmt->bindParam(':metodo_pago', $datos['metodo_pago']);
        $stmt->bindParam(':estado', $datos['estado']);
        
        return $stmt->execute();
    }
    
    // Verificar si un usuario ya compró un curso
    public function verificarCompra($usuario_id, $curso_id) {
        $sql = "SELECT * FROM compras WHERE usuario_id = :usuario_id AND curso_id = :curso_id AND estado = 'completado'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':curso_id', $curso_id);
        $stmt->execute();
        
        return $stmt->fetch() ? true : false;
    }
    
    // Obtener cursos comprados por un usuario
    public function obtenerCursosComprados($usuario_id) {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, u.nombre as capacitador_nombre,
                com.fecha_compra,
                (SELECT COUNT(*) FROM lecciones l 
                 INNER JOIN modulos m ON l.modulo_id = m.id 
                 WHERE m.curso_id = c.id) as total_lecciones,
                (SELECT COUNT(*) FROM progreso p 
                 INNER JOIN lecciones l ON p.leccion_id = l.id
                 INNER JOIN modulos m ON l.modulo_id = m.id
                 WHERE m.curso_id = c.id AND p.usuario_id = ? AND p.completado = 1) as lecciones_completadas
                FROM compras com
                INNER JOIN cursos c ON com.curso_id = c.id
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.capacitador_id = u.id
                WHERE com.usuario_id = ? AND com.estado = 'completado'
                ORDER BY com.fecha_compra DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id, $usuario_id]);
        
        return $stmt->fetchAll();
    }
}
