<?php
// Requerimos el archivo de conexión a la base de datos
require_once __DIR__ . '/../config/conexion.php';

class Factura {
    // Variable privada con tipado estricto para la conexión PDO
    private ?PDO $conexion;

    public function __construct() {
        // Obtenemos la instancia de la conexión
        $this->conexion = Conexion::conectar();
    }

    // Método para listar todas las facturas del taller
    public function obtenerFacturas() {
        // Preparamos la consulta SQL para obtener todas las facturas
        $sql = "SELECT * FROM facturas";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una factura específica por su ID junto con sus detalles
    public function obtenerFacturaPorId($id) {
        // Preparamos la consulta SQL para obtener una factura por su ID
        $sql = "SELECT * FROM facturas WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva factura principal
    public function crearFactura($cliente_dni, $total, $fecha) {
        // Preparamos la consulta SQL para insertar una nueva factura en la base de datos
        // Uso de prepared statements con '?' para evitar SQL Injection
        $sql = "INSERT INTO facturas (cliente_dni, total, fecha) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt->execute([$cliente_dni, $total, $fecha])) {
            // Devolvemos el ID de la factura recién creada para poder asociarle los detalles si hace falta
            return $this->conexion->lastInsertId();
        }
        return false;
    }
}