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

    // Instanciamos el controlador de usuarios y llamamos al método registrar
    $controlador = new usuario_controller();
    $resultado = $controlador->registrar($email, $password);

    if ($resultado) {
        $mensaje = "¡Usuario registrado con éxito!";
        $tipoAlerta = "alert-success"; 
    } else {
        $mensaje = "Hubo un error al registrar el usuario.";
        $tipoAlerta = "alert-error"; 
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Registro</title>
    <link rel="stylesheet" href="../style/registro.css">
</head>
<body>
    <div class="auth-container">
        <h2>MotorFix</h2>
        <p class="auth-subtitle">Crea una nueva cuenta</p>
        
        <?php if($mensaje != ""): ?>
            <div class="alert-message <?php echo $tipoAlerta; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-submit">Registrarse</button>
        </form>

        <div class="auth-links">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>