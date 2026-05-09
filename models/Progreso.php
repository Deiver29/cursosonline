<?php
class Progreso {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Marcar lección como completada
    public function marcarCompletada($usuario_id, $leccion_id) {
        $sql = "INSERT INTO progreso (usuario_id, leccion_id, completado, fecha_completado) 
                VALUES (:usuario_id, :leccion_id, 1, NOW())
                ON DUPLICATE KEY UPDATE completado = 1, fecha_completado = NOW()";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':leccion_id', $leccion_id);
        
        return $stmt->execute();
    }
    
    // Obtener progreso de un curso
    public function obtenerProgresoCurso($usuario_id, $curso_id) {
        $sql = "SELECT 
                COUNT(DISTINCT l.id) as total_lecciones,
                COUNT(DISTINCT CASE WHEN p.completado = 1 THEN l.id END) as lecciones_completadas,
                ROUND((COUNT(DISTINCT CASE WHEN p.completado = 1 THEN l.id END) / COUNT(DISTINCT l.id)) * 100, 2) as porcentaje
                FROM modulos m
                INNER JOIN lecciones l ON m.id = l.modulo_id
                LEFT JOIN progreso p ON l.id = p.leccion_id AND p.usuario_id = :usuario_id
                WHERE m.curso_id = :curso_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':curso_id', $curso_id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}
