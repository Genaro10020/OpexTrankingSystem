<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'responsablesModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
        $val[] = consultarResponsables();
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nombre']) && isset($arreglo['numero_nomina']) && isset($arreglo['correo']) && isset($arreglo['telefono'])){
            $nombre=$arreglo['nombre'];
            $numero_nomina=$arreglo['numero_nomina'];
            $correo=$arreglo['correo'];
            $telefono=$arreglo['telefono'];
            $val[]=insertarResponsable($nombre,$numero_nomina,$correo,$telefono);
        }else{
            $val[] = "No existe todas las variables";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
        // ...
        break;

    default:
        $val[] = "Método HTTP no permitido";
        http_response_code(405); // Método no permitido
        break;
}

echo json_encode($val);
}else{
    header("Location:index.php");
}
?>