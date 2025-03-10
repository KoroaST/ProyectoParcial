<?php
require_once('nusoap/lib/nusoap.php');
require_once('conexion.php');

$server = new soap_server();
$server->configureWSDL('LoginService', 'urn:login');

$server->register('validarUsuario',
    array('usuario' => 'xsd:string', 'clave' => 'xsd:string'),
    array('return' => 'xsd:string'));

function validarUsuario($usuario, $clave) {
    global $conn;

    $query = "SELECT id, nombre, clave FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $clave_hash = $row['clave'];

        // Verificar si la clave coincide con el hash
        if (password_verify($clave, $clave_hash)) {
            return json_encode(array("id" => $row['id'], "nombre" => $row['nombre']));
        } else {
            return 'false'; // Clave incorrecta
        }
    } else {
        return 'false'; // Usuario no encontrado
    }
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
