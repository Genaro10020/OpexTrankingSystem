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
            $val[] = consultarProyectos();
            break;
        case 'POST':
            // Manejar solicitud POST (creación)
            if (
                isset($arreglo['folio']) && isset($arreglo['fecha_alta']) && isset($arreglo['nombre_proyecto']) && isset($arreglo['fuente']) && isset($arreglo['select_planta']) && isset($arreglo['select_area'])
                && isset($arreglo['select_departamento']) && isset($arreglo['select_metodologia']) && isset($arreglo['responsable_id']) && isset($arreglo['misiones'])
                && isset($arreglo['pilares']) && isset($arreglo['objetivos']) && isset($arreglo['impacto_ambiental']) && isset($arreglo['tons_co2'])
                && isset($arreglo['ahorro_duro']) && isset($arreglo['ahorro_suave'])
            ) {
                $folio = $arreglo['folio'];
                $fecha_alta = $arreglo['fecha_alta'];
                $nombre_proyecto = $arreglo['nombre_proyecto'];
                $fuente = $arreglo['fuente'];
                $planta = $arreglo['select_planta'];
                $area = $arreglo['select_area'];
                $departamento = $arreglo['select_departamento'];
                $metodologia = $arreglo['select_metodologia'];
                $responsable_id = $arreglo['responsable_id'];
                $misiones = $arreglo['misiones'];
                $pilares = $arreglo['pilares'];
                $objetivos = $arreglo['objetivos'];
                $impacto_ambiental = $arreglo['impacto_ambiental'];
                $tons_co2 = $arreglo['tons_co2'];
                if ($tons_co2 == "") {
                    $tons_co2 = 0;
                }
                $ahorro_duro = $arreglo['ahorro_duro'];
                $ahorro_suave = $arreglo['ahorro_suave'];
                $misiones = json_encode($misiones, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $pilares = json_encode($pilares, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $objetivos = json_encode($objetivos, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $impacto_ambiental = json_encode($impacto_ambiental, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $val[] = insertarProyecto($folio, $fecha_alta, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id, $misiones, $pilares, $objetivos, $impacto_ambiental, $tons_co2, $ahorro_duro, $ahorro_suave);
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
            if (isset($arreglo['id_proyecto']) && isset($arreglo['status'])) {
                $id_proyecto=$arreglo['id_proyecto'];
                $status=$arreglo['status'];
                $val[] = actualizarStatusCerradoSiguiendo($id_proyecto,$status);
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
