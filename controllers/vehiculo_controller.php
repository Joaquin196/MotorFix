<?php

require_once "../models/vehiculo.php";

class vehiculo_controller {
    
    // Método para obtener todos los vehículos y sus dueños
    public function listar() {
        $vehiculoModel = new Vehiculo();
        // Llamamos al método obtenerVehiculos() del modelo para obtener todos los vehículos junto con el nombre de su dueño
        $vehiculos = $vehiculoModel->obtenerVehiculos();
        return $vehiculos;
    }

    // Método para guardar un nuevo vehículo en la base de datos
    public function guardar($cliente_id, $matricula, $marca, $modelo) {
        $vehiculoModel = new Vehiculo();
        // Llamamos al método crearVehiculo() del modelo para insertar un nuevo vehículo en la base de datos
        $resultado = $vehiculoModel->crearVehiculo($cliente_id, $matricula, $marca, $modelo);
        return $resultado;
    }
}