<?php
// Incluimos el controlador para poder usar sus métodos
require_once "../controllers/cliente_controller.php";

// Instanciamos el controlador
$controlador = new cliente_controller();

// Llamamos al método que lista los clientes
$clientes = $controlador->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Lista de Clientes</title>
</head>
<body>
    <h1>Listado de Clientes</h1>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['id']; ?></td>
            <td><?php echo $cliente['nombre']; ?></td>
            <td><?php echo $cliente['telefono']; ?></td>
            <td><?php echo $cliente['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>