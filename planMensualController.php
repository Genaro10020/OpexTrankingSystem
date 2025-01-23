<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'planMensualModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = "";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
            $id=$_GET['id'];
            $val = consultarPlanMensualAnual($id);
        break;

    case 'POST':
        // Manejar solicitud POST (creación)
            /*if(isset($arreglo['nueva'])){
                $nueva = $arreglo['nueva'];
                $siglas = $arreglo['siglas'];
                $val[] = insertarPlanta($nueva,$siglas);
            } else {
                $val[] = "No se encuentra la variable nueva";
                http_response_code(400); // Bad Request
            }*/
        // ...
        break;
    case 'PUT':
        // Manejar solicitud PUT (actualización)
            /*if(isset($arreglo['idPlanta']) && isset($arreglo['nuevoNombre']) && isset($arreglo['siglas'])){
                $idPlanta=$arreglo['idPlanta'];
                $nuevoNombre=$arreglo['nuevoNombre'];
                $siglas=$arreglo['siglas'];
                $val[]=actualizarPlanta($idPlanta,$nuevoNombre,$siglas);
            }else{
                $val[] = "No existe variable idPlanta";
            }*/
        // ...
        break;

    case 'DELETE':
       
        break;

    default:
        $val = "Método HTTP no permitido";
        http_response_code(405); // Método no permitido
        break;
}

echo json_encode($val);
}else{
    header("Location:index.php");
}
?>