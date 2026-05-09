<?php
class Usuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Registrar nuevo usuario
    public function registrar($datos) {
        $sql = "INSERT INTO usuarios (nombre, email, password, pais, idioma_preferido, rol) 
                VALUES (:nombre, :email, :password, :pais, :idioma, :rol)";
        
        $stmt = $this->db->prepare($sql);
        $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':email', $datos['email']);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':pais', $datos['pais']);
        $stmt->bindParam(':idioma', $datos['idioma']);
        $stmt->bindParam(':rol', $datos['rol']);
        
        return $stmt->execute();
    }
    
    // Iniciar sesión
    public function login($email, $password) {
        $sql = "SELECT * FROM usuarios WHERE email = :email AND activo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        
        return false;
    }
    
    // Obtener usuario por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Actualizar perfil
    public function actualizarPerfil($id, $datos) {
        $sql = "UPDATE usuarios SET 
                nombre = :nombre,
                foto = :foto,
                pais = :pais,
                biografia = :biografia,
                idioma_preferido = :idioma
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':foto', $datos['foto']);
        $stmt->bindParam(':pais', $datos['pais']);
        $stmt->bindParam(':biografia', $datos['biografia']);
        $stmt->bindParam(':idioma', $datos['idioma']);
        
        return $stmt->execute();
    }
    
    // Obtener todos los usuarios (para administrador)
    public function obtenerTodos($filtro = '') {
        $sql = "SELECT id, nombre, email, rol, pais, activo, fecha_registro FROM usuarios";
        
        if (!empty($filtro)) {
            $sql .= " WHERE nombre LIKE :filtro OR email LIKE :filtro";
        }
        
        $sql .= " ORDER BY fecha_registro DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($filtro)) {
            $filtroParam = "%$filtro%";
            $stmt->bindParam(':filtro', $filtroParam);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Cambiar estado de usuario
    public function cambiarEstado($id, $activo) {
        $sql = "UPDATE usuarios SET activo = :activo WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':activo', $activo);
        
        return $stmt->execute();
    }
    
    // Eliminar usuario
    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
