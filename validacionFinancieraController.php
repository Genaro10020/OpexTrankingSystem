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
        if(isset($arreglo['id']) && isset($arreglo['anio']) && isset($arreglo['mes']) && isset($arreglo['validacion'])){
            $id = $arreglo['id'];
            $mes = $arreglo['anio'];
            $anio = $arreglo['mes'];
            $validacion = $arreglo['validacion'];
            $val [] =  actualizarValidacionProyecto($id,$mes,$anio,$validacion);
        }else{
            $val [] =  "No existe todas las Variables";
        }
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