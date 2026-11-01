<?php
require_once "../controllers/UsuarioController.php"; // O la ruta a tu controlador de usuarios

$mensaje = "";

// Verificamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Instanciamos el controlador de usuarios y llamamos al método registrar
    $controlador = new UsuarioController();
    $resultado = $controlador->registrar($email, $password);

    if ($resultado) {
        $mensaje = "¡Usuario registrado con éxito!";
    } else {
        $mensaje = "Hubo un error al registrar el usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    
    <?php if($mensaje != ""): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form action="registro.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>