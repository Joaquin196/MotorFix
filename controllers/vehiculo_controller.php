<?php
// Indicamos que la respuesta va a ser en formato JSON
header('Content-Type: application/json');

// Requerimos el modelo de vehículo
require_once __DIR__ . '/../models/vehiculo.php';

$vehiculoModel = new Vehiculo();

// Detectamos qué acción nos está pidiendo el cliente
$accion = $_REQUEST['accion'] ?? '';

// Switch para manejar las diferentes acciones que nos puede pedir el cliente
switch ($accion) {
    // Acción para listar todos los vehículos
    case 'listar':
        try {
            // Llamamos al método obtenerVehiculos() del modelo para obtener todos los vehículos junto con el nombre de su dueño
            $vehiculos = $vehiculoModel->obtenerVehiculos();
            
            echo json_encode([
                'status' => 'success',
                'vehiculos' => $vehiculos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        break;

    // Acción para guardar un nuevo vehículo
    case 'guardar':
        // Comprobamos que nos llega la petición por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id = $_POST['cliente_id'] ?? '';
            $matricula = $_POST['matricula'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';

            // Si faltan campos obligatorios, devolvemos un error
            if (empty($matricula) || empty($marca) || empty($modelo)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Faltan campos obligatorios por rellenar.'
                ]);
                exit;
            }

            // Llamamos al método crearVehiculo() del modelo para insertar un nuevo vehículo en la base de datos
            $resultado = $vehiculoModel->crearVehiculo($cliente_id, $matricula, $marca, $modelo);

            // Si el vehículo se ha guardado correctamente, devolvemos éxito, si no, un error
            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Vehículo guardado correctamente.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se pudo guardar el vehículo en la base de datos.'
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
            'message' => 'Acción no válida en vehículos.'
        ]);
        break;
}