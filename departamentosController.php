<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'departamentosModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
        $val[] = consultarDepartamentos();
        break;

    case 'POST':
        // Manejar solicitud POST (creación)
            if(isset($arreglo['nueva'])){
                $nueva = $arreglo['nueva'];
               $val [] = insertarDepartamento($nueva);     
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
            $val[]=actualizarDepartamento($id,$nuevo);
        }else{
            $val[] = "No existe variable ID o Nuevo";
        }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarDepartamento($id);
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