<?php
//Carga obligatoriamente el archivo de conexión.
require_once_once "../config/conexion.php"; 

class Cliente {
    // El interrogante ?PDO significa que puede ser un objeto PDO o puede ser null al principio
    private ?PDO $conexion;

    public function __construct() {
        // Llamamos al método estático obtenerInstancia() en conexion.php para aplicar el patrón Singleton
        $this->conexion = Conexion::obtenerInstancia();
    }

    public function obtenerClientes() {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}