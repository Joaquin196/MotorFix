<?php
require_once "../controllers/usuario_controller.php";

$mensaje = "";
// Variable para almacenar el tipo de alerta (éxito o error)
$tipoAlerta = ""; 

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
        $tipoAlerta = "alert-success"; 
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
        $tipoAlerta = "alert-error"; 
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Iniciar Sesión</title>
    <link rel="stylesheet" href="../style/login.css">
</head>
<body>
    <div class="auth-container">
        <h2>MotorFix</h2>
        <p class="auth-subtitle">Accede a tu panel de control</p>
        
        <?php if($mensaje != ""): ?>
            <div class="alert-message <?php echo $tipoAlerta; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-submit">Entrar</button>
        </form>

        <div class="auth-links">
            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>