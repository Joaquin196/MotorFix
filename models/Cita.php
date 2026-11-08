<?php
// Requerimos el archivo de conexión a la base de datos
require_once __DIR__ . '/../config/conexion.php';

class Cita {
    // Variable privada para guardar la instancia de la base de datos PDO
    private ?PDO $conexion;

    public function __construct() {
        // Obtenemos la instancia de la conexión 
        $this->conexion = Conexion::conectar();
    }

    // Método para listar todas las citas del taller
    public function obtenerCitas() {
        // Preparamos la consulta SQL para obtener todas las citas
        $sql = "SELECT * FROM citas"; 
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para registrar una nueva cita
    public function crearCita($cliente_dni, $matricula_vehiculo, $fecha_hora, $estado, $observaciones) {
        // Preparamos la consulta SQL para insertar una nueva cita en la base de datos
        // Los '?' son comodines posicionales, se sustituyen en orden exacto por los valores del array
        $sql = "INSERT INTO citas (cliente_dni, matricula_vehiculo, fecha_hora, estado, observaciones) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$cliente_dni, $matricula_vehiculo, $fecha_hora, $estado, $observaciones]);
    }

    // Método para obtener una cita específica por su ID
    public function obtenerCitaPorId($id) {
        // Preparamos la consulta SQL para obtener una cita por su ID
        $sql = "SELECT * FROM citas WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}