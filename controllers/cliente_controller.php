<?php
// Carga obligatoriamente el archivo de conexión y el modelo Cliente
require_once "../models/cliente.php";

class cliente_controller {
    // Método para listar todos los clientes
    public function listar() {
        $clienteModel = new Cliente();
        // Llamamos al método obtenerClientes() del modelo para obtener todos los clientes
        $clientes = $clienteModel->obtenerClientes();
        
        // Devolvemos los clientes en formato JSON para que puedan ser consumidos por el frontend
        return $clientes;
    }

    // Método para guardar un nuevo cliente
    public function guardar($nombre, $telefono, $email) {
        $clienteModel = new Cliente();
        // Llamamos al método crearCliente() del modelo para insertar un nuevo cliente en la base de datos
        $resultado = $clienteModel->crearCliente($nombre, $telefono, $email);
        return $resultado;
    }

    // Método para obtener un cliente por su ID
    public function obtenerPorId($id) {
        $clienteModel = new Cliente();
        // Llamamos al método obtenerClientePorId() del modelo para obtener los datos de un cliente específico
        $cliente = $clienteModel->obtenerClientePorId($id);
        return $cliente;
    }

    // Método para eliminar un cliente por su ID
    public function borrar($id) {
        $clienteModel = new Cliente();
        // Llamamos al método eliminarCliente() del modelo para eliminar un cliente específico
        $resultado = $clienteModel->eliminarCliente($id);
        return $resultado;
    }
}