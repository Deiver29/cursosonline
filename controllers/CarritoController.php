<?php
class CarritoController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }
    
    public function index() {
        $this->verificarAcceso();
        
        $carritoModel = new Carrito();
        $cursos = $carritoModel->obtenerCursos($_SESSION['usuario_id']);
        
        // Calcular total
        $total = 0;
        foreach ($cursos as $curso) {
            $total += $curso['precio'];
        }
        
        require_once 'views/carrito/index.php';
    }
    
    public function agregar() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $curso_id = $_POST['curso_id'];
            
            // Verificar que no haya comprado el curso
            $compraModel = new Compra();
            if ($compraModel->verificarCompra($_SESSION['usuario_id'], $curso_id)) {
                echo json_encode(['success' => false, 'message' => 'Ya compraste este curso']);
                exit;
            }
            
            $carritoModel = new Carrito();
            if ($carritoModel->agregar($_SESSION['usuario_id'], $curso_id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'El curso ya está en el carrito']);
            }
        }
    }
    
    public function eliminar() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $curso_id = $_POST['curso_id'];
            
            $carritoModel = new Carrito();
            $carritoModel->eliminar($_SESSION['usuario_id'], $curso_id);
            
            header("Location: " . BASE_URL . "carrito");
            exit;
        }
    }
    
    public function checkout() {
        $this->verificarAcceso();
        
        $carritoModel = new Carrito();
        $cursos = $carritoModel->obtenerCursos($_SESSION['usuario_id']);
        
        if (empty($cursos)) {
            header("Location: " . BASE_URL . "carrito");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compraModel = new Compra();
            
            // Procesar cada curso del carrito
            foreach ($cursos as $curso) {
                $datos = [
                    'usuario_id' => $_SESSION['usuario_id'],
                    'curso_id' => $curso['id'],
                    'precio_pagado' => $curso['precio'],
                    'moneda' => $curso['moneda'],
                    'metodo_pago' => $_POST['metodo_pago'],
                    'estado' => 'completado'
                ];
                
                $compraModel->registrar($datos);
            }
            
            // Vaciar carrito
            $carritoModel->vaciar($_SESSION['usuario_id']);
            
            $_SESSION['mensaje'] = "Compra realizada con éxito";
            header("Location: " . BASE_URL . "aprendiz/misCursos");
            exit;
        }
        
        // Calcular total
        $total = 0;
        foreach ($cursos as $curso) {
            $total += $curso['precio'];
        }
        
        require_once 'views/carrito/checkout.php';
    }
}
