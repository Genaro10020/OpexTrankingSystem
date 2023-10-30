<?php
$hostname = 'localhost';
$database = 'opex_tracking_system';
$username = 'root';
$password = '';

$conexion = new mysqli($hostname, $username, $password,$database);

if ($conexion->connect_errno) {
   echo "Error al conectarse con la BD";
}

?>