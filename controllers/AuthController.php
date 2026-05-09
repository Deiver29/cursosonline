<?php
class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($email, $password);
            
            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                $_SESSION['usuario_foto'] = $usuario['foto'];
                $_SESSION['idioma'] = $usuario['idioma_preferido'];
                
                // Redirigir según el rol
                switch ($usuario['rol']) {
                    case 'administrador':
                        header("Location: " . BASE_URL . "admin/dashboard");
                        break;
                    case 'capacitador':
                        header("Location: " . BASE_URL . "capacitador/dashboard");
                        break;
                    default:
                        header("Location: " . BASE_URL . "aprendiz/dashboard");
                }
                exit;
            } else {
                $error = "Credenciales incorrectas";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }
    
    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'pais' => $_POST['pais'],
                'idioma' => $_POST['idioma'],
                'rol' => $_POST['rol']
            ];
            
            $usuarioModel = new Usuario();
            
            if ($usuarioModel->registrar($datos)) {
                // Enviar email de bienvenida
                Email::enviarBienvenida($datos['email'], $datos['nombre']);
                
                $_SESSION['mensaje'] = "Registro exitoso. Te hemos enviado un email de confirmación. Por favor inicia sesión.";
                header("Location: " . BASE_URL . "auth/login");
                exit;
            } else {
                $error = "Error al registrar. El email podría estar en uso.";
                require_once 'views/auth/registro.php';
            }
        } else {
            require_once 'views/auth/registro.php';
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }
}
