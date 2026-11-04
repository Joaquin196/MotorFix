<?php
// Carga obligatoriamente el archivo de conexión y el modelo Usuario
require_once "../models/usuario.php";

class usuario_controller {
    // Método para registrar un nuevo usuario
    public function registrar($email, $password) {
        // Instanciamos el modelo Usuario y llamamos al método registrarUsuario para insertar un nuevo usuario en la base de datos
        $usuarioModel = new Usuario();
        // Llamamos al método registrarUsuario() del modelo para insertar un nuevo usuario en la base de datos
        $resultado = $usuarioModel->registrarUsuario($email, $password);
        return $resultado;
    }

    // Método para verificar el login de un usuario
    public function login($email, $password) {
        // Instanciamos el modelo Usuario y llamamos al método verificarLogin para comprobar las credenciales del usuario
        $usuarioModel = new Usuario();
        // Llamamos al método verificarLogin() del modelo para comprobar las credenciales del usuario
        $resultado = $usuarioModel->verificarLogin($email, $password);
        return $resultado;
    }
}

// Puente AJAX para conectar con las vistas JS
if (isset($_GET['accion'])) {
    header('Content-Type: application/json; charset=utf-8');
    $controller = new usuario_controller();
    $accion = $_GET['accion'];

    if ($accion === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $resultado = $controller->login($email, $password);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'usuario' => $resultado]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Correo o contraseña incorrectos.']);
        }
        exit;
    }

    if ($accion === 'registrar') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $resultado = $controller->registrar($email, $password);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'mensaje' => '¡Usuario registrado con éxito!']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Hubo un error al registrar el usuario.']);
        }
        exit;
    }
}