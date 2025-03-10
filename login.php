<?php
session_start();
include 'conexion.php'; 

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Consulta para verificar las credenciales del usuario
    $query = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña usando Argon2

        // Comentar con Argos

        // if (password_verify($clave, $user['clave'])) {

            // Almacenar información del usuario en la sesión

            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];
            header('Location: dashboard.php'); // Redirigir al dashboard
            exit();
        } else {
            $message = "Contraseña incorrecta."; //  contraseñas incorrectas
        }
    } else {
        $message = "Usuario no encontrado."; // usuarios no encontrados
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Concesionaria</title>
    <link rel="stylesheet" href="css/dashboard.css"> 
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto; 
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%; 
        }

        .submit-btn:hover {
            background-color: #0056b3; 
        }

        .message {
            color: red; /* Color rojo para mensajes de error */
            text-align: center; /* Centrar mensaje */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="text-align:center;">Iniciar Sesión</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div> 
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" required>
            </div>
            <button type="submit" class="submit-btn">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
