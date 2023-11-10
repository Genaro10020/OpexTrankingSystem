<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'proyectosModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
       
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['fecha_alta']) && isset($arreglo['nombre_proyecto']) && isset($arreglo['select_planta']) && isset($arreglo['select_area']) 
        && isset($arreglo['select_departamento']) && isset($arreglo['select_metodologia']) && isset($arreglo['select_responsable']) && isset($arreglo['misiones']) 
        && isset($arreglo['pilares']) && isset($arreglo['objetivos']) && isset($arreglo['impacto_ambiental']) && isset($arreglo['tons_co2'])
        && isset($arreglo['ahorro_duro']) && isset($arreglo['ahorro_suave'])){
            $val[]= true;
        }else{
            $val[]= "No llegaron tadas la variables";
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