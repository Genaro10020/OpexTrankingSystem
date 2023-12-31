<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'misionesModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
        
        if(isset($_GET['relacional'])){
            $val[] = consultarMisionesRelacionadas();
        }else{
            $val[] = consultarMisiones();
            }
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva'])){
            $nueva = $arreglo['nueva'];
            $val [] = insertarMision($nueva);     
        }else{
            $val [] =  "No existe la variable nueva";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nuevo'])){
                $id=$arreglo['id'];
                $nuevo=$arreglo['nuevo'];
                $val[]=actualizarMision($id,$nuevo);
            } else {
                $val[] = "No existe variable ID o Nuevo";
            }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarMision($id);
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