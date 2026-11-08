<?php
// Indicamos que la respuesta va a ser en formato JSON
header('Content-Type: application/json');

// Requerimos el modelo de Cita
require_once __DIR__ . '/../models/Cita.php';

$citaModel = new Cita();

// Detectamos qué acción nos está pidiendo el cliente
$accion = $_REQUEST['accion'] ?? '';

// Switch para manejar las diferentes acciones que nos puede pedir el cliente
switch ($accion) {
    // Acción para listar todas las citas
    case 'listar':
        try {
            $citas = $citaModel->obtenerCitas();
            echo json_encode([
                'status' => 'success',
                'data' => $citas
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        break;

    // Acción para crear una nueva cita
    case 'crear':
        // Comprobamos que nos llega la petición por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recogemos los datos enviados desde el formulario (vía fetch)
            $cliente_dni = $_POST['cliente_dni'] ?? '';
            $matricula_vehiculo = $_POST['matricula_vehiculo'] ?? '';
            $fecha_hora = $_POST['fecha_hora'] ?? '';
            $estado = $_POST['estado'] ?? 'Pendiente';
            $observaciones = $_POST['observaciones'] ?? '';

            // Si el dni, matricula o fecha_hora están vacíos, devolvemos un error
            if (empty($cliente_dni) || empty($matricula_vehiculo) || empty($fecha_hora)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Faltan campos obligatorios por rellenar.'
                ]);
                exit;
            }

            // Llamamos al método del modelo para crear la cita
            $resultado = $citaModel->crearCita($cliente_dni, $matricula_vehiculo, $fecha_hora, $estado, $observaciones);

            //Si la cita se ha creado correctamente, devolvemos un mensaje de éxito, si no, un mensaje de error
            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cita registrada correctamente.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se pudo registrar la cita en la base de datos.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Método no permitido.'
            ]);
        }
        break;

    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Acción no válida.'
        ]);
        break;
}