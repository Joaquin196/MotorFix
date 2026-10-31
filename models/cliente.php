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
        // Medida de seguridad fundamental para evitar inyecciones SQL
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        // Recoge todos los resultados que ha devuelto la base de los datos y los empaqueta en un array asociativo
        return $stmt->fetchAll();
    }

    public function crearCliente($nombre, $telefono, $email) {
        // Preparamos la consulta SQL con parámetros para que nadie pueda colar una inyección SQL por los formularios   
        $sql = "INSERT INTO clientes (nombre, telefono, email) VALUES (:nombre, :telefono, :email)";
        $stmt = $this->conexion->prepare($sql);
        // Asignamos los valores a los parámetros de forma segura
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        // Ejecutamos la consulta y devolvemos true si se ha insertado correctamente o false si ha habido algún error
        return $stmt->execute();
    }

    public function obtenerClientePorId($id) {
        // Preparamos la consulta SQL para obtener un cliente por su ID
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        // Asignamos el valor del ID de forma segura para evitar inyecciones SQL
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Devolvemos el resultado como un array asociativo o false si no se encuentra
        return $stmt->fetch();
    }

    public function eliminarCliente($id) {
        // Preparamos la consulta SQL para eliminar un cliente por su ID
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        // Asignamos el valor del ID de forma segura para evitar inyecciones SQL
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        // Ejecutamos la consulta y devolvemos true si se ha eliminado correctamente o false si ha habido algún error
        return $stmt->execute();
    }
}