<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'validacionFinancieraModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $anio=$_GET['anio'];
        // Manejar solicitud GET (consultar)
        $val[] = consultarValidacion($anio);
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['mes']) && isset($arreglo['anio']) && isset($arreglo['suave']) && isset($arreglo['duro']) && isset($arreglo['real_duro']) && isset($arreglo['validar']) ){
            $id = $arreglo['id'];
            $mes = $arreglo['mes'];
            $anio = $arreglo['anio'];
            $suave = $arreglo['suave'];
            $duro = $arreglo['duro'];
            $real_duro = $arreglo['real_duro'];
            $validar = $arreglo['validar'];
            if($id==""){
                $val [] = insertarValidacion($mes,$anio,$suave,$duro,$real_duro,$validar);    
            }else{
                $val [] = actualizarValidacion($mes,$anio,$suave,$duro,$real_duro,$validar,$id);    
            }
            
        }else{
            $val [] =  "No existe todas las Variables";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nuevo'])){
                $id=$arreglo['id'];
                $nuevo=$arreglo['nuevo'];
                $val[]=actualizarMetodologia($id,$nuevo);
            }else{
                $val[] = "No existe variable ID o Nuevo";
            }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarMetodologia($id);
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