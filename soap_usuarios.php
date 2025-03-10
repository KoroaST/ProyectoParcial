<?php
require_once('nusoap/lib/nusoap.php');
require_once('conexion.php');

$server = new soap_server();
$server->configureWSDL('UserService', 'urn:usuarios');

$server->register('crearUsuario', array('nombre' => 'xsd:string', 'apellido' => 'xsd:string', 'usuario' => 'xsd:string', 'clave' => 'xsd:string'), array('return' => 'xsd:string'));

function crearUsuario($nombre, $apellido, $usuario, $clave) {
    global $conn;

    // Hashear la clave antes de almacenarla
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellido, usuario, clave) VALUES ('$nombre', '$apellido', '$usuario', '$clave_hash')";
    
    if ($conn->query($query) === TRUE) {
        return "Usuario creado con éxito";
    } else {
        return "Error al crear usuario: " . $conn->error;
    }
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
