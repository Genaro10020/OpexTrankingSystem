<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'planModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $anio=$_GET['anio'];
        // Manejar solicitud GET (consultar)
        $val[] = consultarPlan($anio);
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['mes']) && isset($arreglo['anio']) && isset($arreglo['valor']) && isset($arreglo['id']) ){
            $id = $arreglo['id'];
            $mes = $arreglo['mes'];
            $anio = $arreglo['anio'];
            $valor = $arreglo['valor'];
            if($id==""){
                $val [] = insertarPlan($mes,$anio,$valor,$id);    
            }else{
                $val [] = actualizarPlan($valor,$id);    
            }
        }else{
            $val [] =  "No existe todas las Variables";
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