<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'ahorroFinancieroModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['anio'])){
            $anio = $_GET['anio'];
            $val =  consultarAhorroFinanciero($anio);
        }else{
            $val[] =  "No me llegó el año";
        }
        // Manejar solicitud GET (consultar)
        
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['id_proyecto']) && isset($arreglo['select_anio_calendario']) && isset($arreglo['mes']) && isset($arreglo['ahorroFinanciero'])){
            $id_proyecto = $arreglo['id_proyecto'];
            $anio = $arreglo['select_anio_calendario'];
            $mes = $arreglo['mes'];
            $ahorroFinanciero = $arreglo['ahorroFinanciero'];
            //$val[] =
            $val[] = insertarAhorroFinanciero($id_proyecto, $anio, $mes, $ahorroFinanciero);

        } else {
            $val[] = "No se encuentra la variable nueva";
            http_response_code(400); // Bad Request
        }

        // ...
        break;
    case 'PUT':
        // Manejar solicitud PUT (actualización)
        
        // ...
        break;
    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
           /* if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarArea($id);
            } else {
                $val[] = "No llego la varible ID".$arreglo['id'];
            //  http_response_code(400); // Bad Request
            }*/
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