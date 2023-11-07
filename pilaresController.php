<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'pilaresModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];
$ids = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
            $val[] = consultarPilares();
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva']) && isset($arreglo['siglas']) && isset($arreglo['id_mision'])){
            $nueva=$arreglo['nueva'];
            $siglas = $arreglo['siglas'];
            $id_mision = $arreglo['id_mision'];
            $val[] =insertarPilares($nueva,$siglas,$id_mision);
        }else if(isset($arreglo['idsMisiones'])){
            $idsMisiones=$arreglo['idsMisiones'];
            $val[] =consultarPilaresIDmisiones($idsMisiones);
        }else{
            $val[]= "No llegaron las variables";
        }
            
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
        if(isset($arreglo['id'])){
            $id = $arreglo['id'];
                $val[] = eliminarPilar($id);
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