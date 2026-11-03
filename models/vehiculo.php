<?php

require_once "../config/conexion.php";
require_once "Cliente.php"; // Importamos la clase Cliente para poder instanciarla y cumplir con la POO

class Vehiculo {
    // Variable privada para guardar la instancia de la base de datos PDO
    private ?PDO $db;

    // Propiedades privadas del vehículo 
    private ?int $id = null;
    private ?int $cliente_id = null;
    private ?string $matricula = null;
    private ?string $marca = null;
    private ?string $modelo = null;
    
    // Relación de objetos: Un Vehículo contiene un objeto Cliente 
    private ?Cliente $cliente = null;

    public function __construct() {
        // Inicializamos la conexión usando el Singleton
        $this->db = Conexion::obtenerInstancia();
    }

    // Método para obtener todos los vehículos junto con el objeto de su dueño
    public function obtenerVehiculos() {
        // Consultamos únicamente la tabla de vehículos de forma limpia
        $sql = "SELECT * FROM vehiculos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vehiculos = [];

        foreach ($resultados as $data) {
            // Instanciamos el objeto Vehiculo por cada registro
            $vehiculo = new self();
            $vehiculo->id = $data['id'];
            $vehiculo->cliente_id = $data['cliente_id'];
            $vehiculo->matricula = $data['matricula'];
            $vehiculo->marca = $data['marca'];
            $vehiculo->modelo = $data['modelo'];

            // Instanciamos el objeto Cliente para obtener los datos del dueño del vehículo
            $clienteObj = new Cliente();
            // Verificamos si el método obtenerClientePorId existe antes de llamarlo
            $vehiculo->cliente = method_exists($clienteObj, 'obtenerClientePorId') 
                ? $clienteObj->obtenerClientePorId($data['cliente_id']) 
                : null;

            $vehiculos[] = $vehiculo;
        }

        // Devolvemos un array de objetos Vehiculo, cada uno con su respectivo objeto Cliente
        return $vehiculos; 
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

    // Getters necesarios para poder leer las propiedades y el objeto cliente desde las vistas o controladores
    public function getId() { return $this->id; }
    public function getClienteId() { return $this->cliente_id; }
    public function getMatricula() { return $this->matricula; }
    public function getMarca() { return $this->marca; }
    public function getModelo() { return $this->modelo; }
    public function getCliente() { return $this->cliente; }
}