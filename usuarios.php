<?php
session_start();
include 'conexion.php';

// Verificar si el usuario tiene el rol de administrador
if ($_SESSION['rol'] !== 'admin') {
    header('Location: dashboard.php'); // Redirige a usuarios no administradores
    exit();
}

// Consulta para obtener todos los usuarios
$query = "SELECT id, nombre, usuario, rol, fecha_creacion FROM usuarios";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios Existentes</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .dashboard-container {
            max-width: 960px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons a {
            padding: 5px 10px;
            margin-right: 5px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .action-buttons .edit-btn {
            background-color: #28a745; /* Verde */
        }

        .action-buttons .edit-btn:hover {
            background-color: #218838; /* Verde oscuro */
        }

        .action-buttons .delete-btn {
            background-color: #dc3545; /* Rojo */
        }

        .action-buttons .delete-btn:hover {
            background-color: #c82333; /* Rojo oscuro */
        }

        .action-buttons-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-buttons-container a {
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none; /* Sin subrayado */
        }

        .back-btn {
            background-color: #6c757d; /* Gris */
        }

        .back-btn:hover {
            background-color: #5a6268; /* Gris oscuro */
        }

        .dashboard-btn {
            background-color: #007bff; /* Azul */
        }

        .dashboard-btn:hover {
            background-color: #0056b3; /* Azul oscuro */
        }
    </style>
    <script>
        function confirmarEliminar() {
            return confirm("¿Estás seguro de que deseas eliminar este usuario?");
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Encabezado -->
        <div class="dashboard-header">
            <h1>Gestionar Usuarios Existentes</h1>
        </div>

        <!-- Tabla de Usuarios -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($row['rol'])); ?></td> <!-- Capitaliza la primera letra -->
                        <td><?php echo htmlspecialchars($row['fecha_creacion']); ?></td>
                        <td class="action-buttons">
                            <?php if ($row['rol'] === 'admin'): ?>
                                <!-- No permitir editar/eliminar administradores -->
                                No permitido
                            <?php else: ?>
                                <!-- Permitir editar/eliminar usuarios normales -->
                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="edit-btn">Editar</a>
                                <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirmarEliminar()">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="6">No hay usuarios registrados.</td> <!-- Mensaje si no hay registros -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botones de Acción -->
        <div class="action-buttons-container">
            <a href="javascript:history.back()" class="back-btn">Atrás</a>
            <a href="dashboard.php" class="dashboard-btn">Regresar al Dashboard</a>
        </div>
    </div>

</body>
</html>
