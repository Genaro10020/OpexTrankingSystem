<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'estandaresCO2Model.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $val[] = consultarEstandaresCO2();
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva']) && isset($arreglo['cantidad']) && isset($arreglo['unidadMedida'])){
            $nueva = $arreglo['nueva'];
            $cantidad = $arreglo['cantidad'];
            $unidadMedida = $arreglo['unidadMedida'];
           $val [] = insertarEstandaresCO2($nueva,$cantidad,$unidadMedida);     
        }else{
            $val [] =  "No existe la variable nueva";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nuevo']) && isset($arreglo['cantidad']) && isset($arreglo['unidadMedida'])){
                $id=$arreglo['id'];
                $nuevo=$arreglo['nuevo'];
                $cantidad=$arreglo['cantidad'];
                $unidadMedida=$arreglo['unidadMedida'];
                $val[]=actualizarEstandaresCO2($id,$nuevo,$cantidad,$unidadMedida);
            }else{
                $val[] = "No existe variable ID o Nuevo";
            }
          
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarEstandares($id);
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