<?php
require_once "../controllers/usuario_controller.php";

$mensaje = "";

// Verificamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Instanciamos el controlador de usuarios y llamamos al método login
    $controlador = new usuario_controller();
    $usuario = $controlador->login($email, $password);

    if ($usuario) {
        $mensaje = "¡Login exitoso! Bienvenido, " . $usuario['email'];
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión en MotorFix</h2>
    
    <?php if($mensaje != ""): ?>
        <p style="color: blue;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
</body>
</html>