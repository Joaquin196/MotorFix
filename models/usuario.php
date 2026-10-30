<?php
// Incluir archivo de conexión Singleton para poder usar la base de datos
// __DIR__ coge la carpeta actual (models) y sube un nivel para entrar a config/conexion.php
require_once __DIR__ . '/../config/conexion.php';

class Usuario {
    // Variable privada para guardar la instancia de la base de datos PDO
    private ?PDO $db;

    // Constructor: se ejecuta automáticamente al instanciar new Usuario()
    public function __construct() {
        // Le pedimos a nuestra clase Singleton que nos dé la conexión única
        $this->db = Conexion::obtenerInstancia();
    }
}

// Método para registrar un usuario nuevo con contraseña cifrada en BCrypt
public function registrar(string $nombre, string $email, string $password, string $rol = 'Cliente'): bool {
    // Ciframos la contraseña usando BCrypt 
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Preparamos la consulta SQL con parámetros para que nadie pueda colar una inyección SQL por los formularios
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
    $stmt = $this->db->prepare($sql);

    // Ejecutamos la consulta pasando los valores de forma segura
    return $stmt->execute([
        ':nombre'   => $nombre,
        ':email'    => $email,
        ':password' => $passwordHash,
        ':rol'      => $rol
    ]);
}
    
// Método para buscar un usuario por su email 
public function obtenerPorEmail(string $email): ?array {

    // Busca en la tabla el registro que coincida exactamente con el email introducido
    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

    // Recupera los datos de ese usuario en forma de array asociativo
    $stmt = $this->db->prepare($sql);
    
    $stmt->execute([':email' => $email]);
        
    $usuario = $stmt->fetch();

    // Si encuentra el usuario, devuelve sus datos, si no, devuelve null
    return $usuario ? $usuario : null;
}
    