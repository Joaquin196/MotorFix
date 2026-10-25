<?php

class Conexion {
    private static ?PDO $instancia = null;
    
    private static string $host = "localhost";
    private static string $db   = "motorfix_db";
    private static string $user = "root";
    private static string $pass = "";
    private static string $charset = "utf8mb4";

    private function __construct() {}

    public static function obtenerInstancia(): PDO {
        if (self::$instancia === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
                $opciones = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                self::$instancia = new PDO($dsn, self::$user, self::$pass, $opciones);
            } catch (PDOException $e) {
                throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }

    private function __clone() {}

    public function __wakeup() {
        throw new Exception("No se puede deserializar una instancia de Singleton.");
    }
}