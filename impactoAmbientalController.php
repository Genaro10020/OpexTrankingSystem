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
        }else if(isset($_GET['accion']) && $_GET['accion'] =='buscar por nombre'){
            $impactos = $_GET['impactos'];
            $val = buscarCoincidenciadeNombreImpactosAmbientales($impactos);//buscarImpactoAmbientalPorNombre($nombre);

        }else{
            $val[] = consultarImpactoAmbiental();
        }
            
        break;
    case 'POST':
        // Manejar solicitud POST (creación)
        if(isset($arreglo['aspecto']) && isset($arreglo['unidad']) && isset($arreglo['clasificacion']) && isset($arreglo['ciclo']) && isset($arreglo['io'])
            && isset($arreglo['impacto']) && isset($arreglo['requisito']) && isset($arreglo['alcance']) && isset($arreglo['CO2']) && isset($arreglo['CH4']) 
            && isset($arreglo['NO2']) && isset($arreglo['CO2CO2e']) && isset($arreglo['CH4CO2e']) && isset($arreglo['N2OCO2e'])){

            $aspecto = $arreglo['aspecto'];
            $unidad = $arreglo['unidad'];
            $clasificacion = $arreglo['clasificacion'];
            $ciclo = $arreglo['ciclo'];
            $io = $arreglo['io'];
            $impacto = $arreglo['impacto']; 
            $requisito = $arreglo['requisito'];
            $alcance = $arreglo['alcance'];
            $CO2 = $arreglo['CO2'];
            $CH4 = $arreglo['CH4'];
            $NO2 = $arreglo['NO2'];
            $CO2CO2e = $arreglo['CO2CO2e'];
            $CH4CO2e = $arreglo['CH4CO2e'];
            $N2OCO2e = $arreglo['N2OCO2e'];

            $val [] = insertarImpactoAmbiental($aspecto,$unidad,$clasificacion,$ciclo,$io,$impacto,$requisito,
            $alcance,$CO2,$CH4,$NO2,$CO2CO2e,$CH4CO2e,$N2OCO2e);     
        }else if(isset($arreglo['suma'])){
            $val[] = sumaImpactoAmbiental();
        }else{
            $val [] =  "No existe la variable nueva";
        }
        // ...
        break;

    case 'PUT':
        // Manejar solicitud PUT (actualización)
            if(isset($arreglo['id']) && isset($arreglo['aspecto']) && isset($arreglo['unidad']) && isset($arreglo['clasificacion']) && isset($arreglo['ciclo']) 
                && isset($arreglo['io']) && isset($arreglo['impacto']) && isset($arreglo['requisito']) && isset($arreglo['alcance']) && isset($arreglo['CO2']) 
                && isset($arreglo['CH4']) && isset($arreglo['NO2']) && isset($arreglo['CO2CO2e']) && isset($arreglo['CH4CO2e']) && isset($arreglo['N2OCO2e'])){

                $id=$arreglo['id'];
                $aspecto = $arreglo['aspecto'];
                $unidad = $arreglo['unidad'];
                $clasificacion = $arreglo['clasificacion'];
                $ciclo = $arreglo['ciclo'];
                $io = $arreglo['io'];
                $impacto = $arreglo['impacto']; 
                $requisito = $arreglo['requisito'];
                $alcance = $arreglo['alcance'];
                $CO2 = $arreglo['CO2'];
                $CH4 = $arreglo['CH4'];
                $NO2 = $arreglo['NO2'];
                $CO2CO2e = $arreglo['CO2CO2e'];
                $CH4CO2e = $arreglo['CH4CO2e'];
                $N2OCO2e = $arreglo['N2OCO2e'];

                $val[]=actualizarImpactoAmbiental($id,$aspecto,$unidad,$clasificacion,$ciclo,$io,$impacto,$requisito,
                $alcance,$CO2,$CH4,$NO2,$CO2CO2e,$CH4CO2e,$N2OCO2e);
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