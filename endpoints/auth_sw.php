<?php
// Iniciamos la sesión para comprobar el estado del usuario
session_start();

// Indicamos que la respuesta será en formato JSON para las peticiones AJAX 
header('Content-Type: application/json');

// Recogemos la acción solicitada
$accion = $_REQUEST['accion'] ?? 'verificar';

switch ($accion) {
    case 'verificar':
        // Comprobamos si el usuario ya tiene una sesión activa
        if (isset($_SESSION['usuario']) || isset($_SESSION['user'])) {
            echo json_encode([
                'status' => 'success',
                'authenticated' => true,
                'usuario' => $_SESSION['usuario'] ?? $_SESSION['user']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'authenticated' => false,
                'message' => 'Acceso no autorizado. Inicia sesión.'
            ]);
        }
        break;

    case 'logout':
        // Destruimos la sesión por completo
        session_unset();
        session_destroy();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Sesión cerrada correctamente.'
        ]);
        break;

    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Acción de autenticación no válida.'
        ]);
        break;
}