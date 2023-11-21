<?php
session_start();
if(isset($_SESSION['nombre'])){
include 'objetivosModel.php';
$arreglo = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
$val = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Manejar solicitud GET (consultar)
        //$lo = array([1,2,3],true);
        if($_GET['relacional']=="relacionada"){
            $val[] = consultarObjetivosRelacional();
        } else if($_GET['relacional']=='objetivoNorelacionada') { 
            $val[] = consultarObjetivos();
            } else{
            $val[] = 'No existe la relacional';
            }
            
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['nueva']) && isset($arreglo['siglas']) && isset($arreglo['id_pilar'])){
            $nueva = $arreglo['nueva'];
            $siglas = $arreglo['siglas'];
            $id_pilar = $arreglo['id_pilar'];
            $val [] = insertarObjetivo($nueva,$siglas,$id_pilar);     
        }else if(isset($arreglo['idsPilares'])){
            $idsPilares=$arreglo['idsPilares'];
            $val[] =consultarObjetivosIDpilares($idsPilares);
        }else{
            $val [] =  "No existe la variable nueva o siglas";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['nombre']) && isset($arreglo['siglas']) && isset($arreglo['id_pilar'])){
                $id = $arreglo['id'];
                $nombre = $arreglo['nombre'];
                $siglas = $arreglo['siglas'];
                $id_pilar = $arreglo['id_pilar'];
                $val[] = actualizarObjetivo($nombre,$siglas,$id_pilar,$id);
            }else if(isset($arreglo['id']) && isset($arreglo['nuevo']) && isset($arreglo['siglas']) && isset($arreglo['select_pilar'])){
                $id = $arreglo['id'];
                $nombre = $arreglo['nuevo'];
                $siglas = $arreglo['siglas'];
                $select_pilar = $arreglo['select_pilar'];
                $val[] = actualizarObjetivos($nombre,$siglas,$select_pilar,$id);
            } else {
                $val[] = "No existe variable ID o Nuevo";
            }
        // ...
        break;

    case 'DELETE':
        // Manejar solicitud DELETE (eliminación)
            if(isset($arreglo['id'])){
                $id = $arreglo['id'];
                $val[] = eliminarObjetivo($id);
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