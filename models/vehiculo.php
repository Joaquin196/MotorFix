<?php

require_once "../config/conexion.php";

class Vehiculo {
    // Variable privada para guardar la instancia de la base de datos PDO
    private ?PDO $db;

    public function __construct() {
        // Inicializamos la conexión usando el Singleton
        $this->db = Conexion::obtenerInstancia();
    }

    // Método para obtener todos los vehículos junto con el nombre de su dueño
    public function obtenerVehiculos() {
        $sql = "SELECT v.*, c.nombre as cliente_nombre 
                FROM vehiculos v 
                INNER JOIN clientes c ON v.cliente_id = c.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para registrar un nuevo vehículo en la base de datos
    public function crearVehiculo($cliente_id, $matricula, $marca, $modelo) {
        $sql = "INSERT INTO vehiculos (cliente_id, matricula, marca, modelo) 
                VALUES (:cliente_id, :matricula, :marca, :modelo)";
        $stmt = $this->db->prepare($sql);
        
        // Asignamos los valores a los parámetros de forma segura para evitar inyecciones SQL
        $stmt->bindParam(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(":matricula", $matricula, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $modelo, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}