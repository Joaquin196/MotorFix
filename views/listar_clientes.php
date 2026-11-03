<?php
// Incluimos el controlador de clientes para obtener la lista de clientes
require_once "../controllers/cliente_controller.php";

// Instanciamos el controlador de clientes para obtener los datos
$controlador = new cliente_controller();
$clientes = $controlador->listar(); // Asegúrate de que tu método de listar devuelva un array
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotorFix - Listado de Clientes</title>
    <link rel="stylesheet" href="../style/listar_clientes.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Panel de Clientes - MotorFix</h2>
            <a href="#" class="btn-action">+ Nuevo Cliente</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo $cliente['id']; ?></td>
                                <td><?php echo $cliente['nombre']; ?></td>
                                <td><?php echo $cliente['email']; ?></td>
                                <td><?php echo $cliente['telefono']; ?></td>
                                <td class="acciones-links">
                                    <a href="#">Editar</a>
                                    <a href="#" style="color: #f87171;">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-data">No hay clientes registrados en el sistema.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>