<?php
session_start();
include 'conexion.php'; // Incluye tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Consulta para validar las credenciales
    $stmt = $conn->prepare("SELECT id, nombre, rol FROM usuarios WHERE usuario = ? AND clave = ?");
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Usuario encontrado, obtener datos
        $stmt->bind_result($id, $nombre, $rol);
        $stmt->fetch();

        // Guardar información en la sesión
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $nombre;
        $_SESSION['rol'] = $rol; // Guardar el rol del usuario

        header('Location: dashboard.php'); // Redirigir al dashboard
        exit();
    } else {
        // Credenciales incorrectas
        header('Location: login.php?error=1');
        exit();
    }
}
?>
