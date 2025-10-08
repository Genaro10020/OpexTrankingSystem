<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'impactoAmbientalModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
        //accion:'',
        //id_proyecto:id
        if(isset($_GET['accion']) && $_GET['accion'] =='impactos con datos'){
            $id_proyecto = $_GET['id_proyecto'];
            $val = consultarImpactosAmbientalesConDatos($id_proyecto);
        }else{
            $val[] = consultarImpactoAmbiental();
        }
            
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva']) && isset($arreglo['cantidad']) && isset($arreglo['unidadMedida'])){
            $nueva = $arreglo['nueva'];
            $cantidad = $arreglo['cantidad'];
            $unidadMedida = $arreglo['unidadMedida'];
            $val [] = insertarImpactoAmbiental($nueva,$cantidad,$unidadMedida);     
        }else if(isset($arreglo['suma'])){
            $val[] = sumaImpactoAmbiental();
        }else{
            $val [] =  "No existe la variable nueva";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nuevoNombre']) && isset($arreglo['cantidad']) && isset($arreglo['unidadMedida'])){
                $id=$arreglo['id'];
                $nuevoNombre = $arreglo['nuevoNombre'];
                $cantidad = $arreglo['cantidad'];
                $unidadMedida = $arreglo['unidadMedida'];
                $val[]=actualizarImpactoAmbiental($id,$nuevoNombre,$cantidad,$unidadMedida);
            }else{
                $val[] = "No existe variable ID o Nuevo";
            }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarImpactoAmbiental($id);
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
    session_destroy();
    header("Location:index.php");
}
?>