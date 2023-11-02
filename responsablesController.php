<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'responsablesModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
           
            
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
        }else if(isset($arreglo['id'])){
            $id=$arreglo['id'];
            $val[] = consultarResponsableID($id);
        }else{
            $val[] = "No existe todas las variables";
        }

        // ...
        break;
    case 'PUT':
        // Manejar solicitud PUT (actualización)
        if(isset($arreglo['nombre']) && isset($arreglo['numero_nomina']) && isset($arreglo['correo']) && isset($arreglo['telefono']) && isset($arreglo['id'])){
            $nombre=$arreglo['nombre'];
            $numero_nomina=$arreglo['numero_nomina'];
            $correo=$arreglo['correo'];
            $telefono=$arreglo['telefono'];
            $id=$arreglo['id'];
            $val[] = actualizarResponsable($id,$nombre,$numero_nomina,$correo,$telefono);
        }else{
            $val[] = "No llegaron todas la variables requeridas";
        }
        
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
        if(isset($arreglo['idResponsable'])){
            $idResponsable=$arreglo['idResponsable'];
            $val [] =   eliminarResponsable($idResponsable);
        }else{
            $val[] = "No existe ID";
        }
       
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