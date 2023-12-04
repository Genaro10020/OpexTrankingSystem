<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'fuentesModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
            $val[] = consultarFuentes();
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva']) && isset($arreglo['siglas'])){
            $nueva = $arreglo['nueva'];
            $siglas=$arreglo['siglas'];
            $val [] = insertarFuente($nueva,$siglas);     
        }else{
            $val [] =  "No existen todas las variables";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nuevo']) && isset($arreglo['siglas'])){
                $id=$arreglo['id'];
                $nuevo=$arreglo['nuevo'];
                $siglas=$arreglo['siglas'];
                $val[]=actualizarFuente($id,$nuevo,$siglas);
            }else{
                $val[] = "No existe variable ID o Nuevo";
            }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarFuente($id);
            } else {
                $val[] = "No llego la varible ID".$arreglo['id'];
            //  http_response_code(400); // Bad Request
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