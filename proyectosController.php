<?php
session_start();
if (isset($_SESSION['nombre'])) {
    include 'proyectosModel.php';
    $arreglo = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    $val = [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Manejar solicitud GET (consultar)
            
            if (isset($_GET['accion'])) {
                if($_GET['accion']=='suma'){
                    $val[] = consultarSumaProyecto();
                }
                if($_GET['accion']=='calendario'){
                    $anio=$_GET['anio'];
                    //$val[] = 'Hola'.$anio;
                    $val[] = consultarCalendarioProyecto($anio);
                }
                if($_GET['accion']=='sumar valores'){
                    $val[] = sumaValoresGonher();
                }
            }else {
                $val[] = consultarProyectos();
            }
 
            break;
        case 'POST':
            // Manejar solicitud POST (creación)
            if (isset($arreglo['folio']) && isset($arreglo['fecha_alta']) && isset($arreglo['nombre_proyecto']) && isset($arreglo['fuente']) && isset($arreglo['select_planta']) && isset($arreglo['select_area'])
                && isset($arreglo['select_departamento']) && isset($arreglo['select_metodologia']) && isset($arreglo['responsable_id']) && isset($arreglo['observador']) && isset($arreglo['misiones'])
                && isset($arreglo['pilares']) && isset($arreglo['objetivos']) && isset($arreglo['impacto_ambiental']) && isset($arreglo['valores']) && isset($arreglo['tons_co2'])
                && isset($arreglo['ahorro_duro']) && isset($arreglo['ahorro_suave']) || isset($arreglo['accion'])) {
                $folio = $arreglo['folio'];
                $fecha_alta = $arreglo['fecha_alta'];
                $nombre_proyecto = $arreglo['nombre_proyecto'];
                $fuente = $arreglo['fuente'];
                $planta = $arreglo['select_planta'];
                $area = $arreglo['select_area'];
                $departamento = $arreglo['select_departamento'];
                $metodologia = $arreglo['select_metodologia'];
                $responsable_id = $arreglo['responsable_id'];
                $observador = $arreglo['observador'];
                $misiones = $arreglo['misiones'];
                $pilares = $arreglo['pilares'];
                $objetivos = $arreglo['objetivos'];
                $impacto_ambiental = $arreglo['impacto_ambiental'];
                $valores = $arreglo['valores'];
                $tons_co2 = $arreglo['tons_co2'];
                if ($tons_co2 == "") {
                    $tons_co2 = 0;
                }
                $ahorro_duro = $arreglo['ahorro_duro'];
                $ahorro_suave = $arreglo['ahorro_suave'];
                $misiones = json_encode($misiones, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $observador = json_encode($observador, JSON_UNESCAPED_UNICODE); //conviert
                $pilares = json_encode($pilares, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $objetivos = json_encode($objetivos, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $impacto_ambiental = json_encode($impacto_ambiental, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $valores = json_encode($valores, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                    if($arreglo['accion']=="Alta Proyecto"){
                        $val[] = insertarProyecto($folio, $fecha_alta, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id,$observador, $misiones, $pilares, $objetivos, $impacto_ambiental,$valores, $tons_co2, $ahorro_duro, $ahorro_suave);
                    }
                    else if($arreglo['accion']=="Actualizar Proyecto"){//ACTUALIZAR PROYECTO
                       if(isset($arreglo['id_actualizar'])){
                        $id=$arreglo['id_actualizar'];
                        $val[] = actualizarProyecto($id,$valores);
                       }else{
                        $val[] = "No llego el ID proyecto actualizar";
                       }
                    }else{
                        $val[] = "No exista esa acción en insertar o actualizar proyecto";
                    }
            } else if (isset($arreglo['id_proyecto'])) {
                $id_proyecto = $arreglo['id_proyecto'];
                $val[] = consultarProyectosID($id_proyecto);
            } else {
                $val[] = "No llegaron tadas la variables";
            }
            // ...
            break;
        case 'PUT':
            // Manejar solicitud PUT (actualización)
            if($arreglo['accion']=="Guardar Estatus"){
                if (isset($arreglo['id_proyecto']) && isset($arreglo['status'])) {
                    $id_proyecto = $arreglo['id_proyecto'];
                    $status = $arreglo['status'];
                    $val[] = actualizarStatusCerradoSiguiendo($id_proyecto, $status);
                }else{
                    $val[] = "No llegaron todas la variables para Guardar Estatus";
                }
            }else{
                $val[] = "No existe la varible accion";
            }
           
            // ...
            break;
        case 'DELETE':
            // Manejar solicitud DELETE (eliminación)
            if (isset($arreglo['id'])) {
                $id = $arreglo['id'];
                $val[] = eliminarProyecto($id);
            } else {
                $val[] = "No llego la varible ID" . $arreglo['id'];
                //  http_response_code(400); // Bad Request
            }
            // ...
            // ...
            break;
        default:
            $val[] = "Método HTTP no permitido";
            http_response_code(405); // Método no permitido
            break;
    }

    echo json_encode($val);
} else {
    header("Location:index.php");
}
