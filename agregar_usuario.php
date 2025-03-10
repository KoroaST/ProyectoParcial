<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Incluir el archivo de conexión
include('conexion.php');

// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

// Validar los datos (opcional)

// Llamar al servicio SOAP para crear el usuario
require_once('nusoap/lib/nusoap.php');

$client = new nusoap_client('soap_usuarios.php?wsdl', true);

$params = array('nombre' => $nombre, 'apellido' => $apellido, 'usuario' => $usuario, 'clave' => $clave);
$result = $client->call('crearUsuario', $params);

if ($client->fault) {
    echo 'Fault: ' . print_r($result);
} else {
    $err = $client->getError();
    if ($err) {
        echo 'Error: ' . $err;
    } else {
        echo $result; // Mostrar el mensaje del servicio SOAP
        header('Location: usuarios.php'); // Redireccionar a la página de gestión de usuarios
        exit();
    }
}
?>
