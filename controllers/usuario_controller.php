<?php
// Carga obligatoriamente el archivo de conexión y el modelo Usuario
require_once "../models/usuario.php";

class usuario_controller {
    // Método para registrar un nuevo usuario
    public function registrar($email, $password) {
        // Instanciamos el modelo Usuario y llamamos al método registrarUsuario para insertar un nuevo usuario en la base de datos
        $usuarioModel = new Usuario();
        // Llamamos al método registrarUsuario() del modelo para insertar un nuevo usuario en la base de datos
        $resultado = $usuarioModel->registrarUsuario($email, $password);
        return $resultado;
    }
}