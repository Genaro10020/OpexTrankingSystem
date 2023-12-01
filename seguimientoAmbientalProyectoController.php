<?php
session_start();
if (isset($_SESSION['nombre'])) {
    include 'seguimientoAmbientalProyectoModel.php';
    $arreglo = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    $val = [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Manejar solicitud GET (consultar)

            break;
        case 'POST':
            // Manejar solicitud POST (creación)
            if (isset($arreglo['id_proyecto'])) {
                $id_proyecto = $arreglo['id_proyecto'];
                $mes = $arreglo['mes'];
                $anio = $arreglo['anio'];
                $toneladas = $arreglo['input_tons_co2'];
                $inputImpactoAmbiental = $arreglo['inputImpactoAmbiental'];
                $suave = $arreglo['input_ahorro_suave'];
                $duro = $arreglo['input_ahorro_duro'];
                $val[] = guardarSeguimietoInicial($id_proyecto, $mes, $anio, $toneladas, $inputImpactoAmbiental, $suave, $duro);
            } else {
                $val[] = "No llegaron todas las variables";
            }
            // ...
            break;
        case 'PUT':
            // Manejar solicitud PUT (actualización)
            if (isset($arreglo['id_proyecto'])) {
                $id_proyecto = $arreglo['id_proyecto'];
                $mes = $arreglo['mes'];
                $anio = $arreglo['anio'];
                $toneladas = $arreglo['input_tons_co2'];
                $inputImpactoAmbiental = $arreglo['inputImpactoAmbiental'];
                $idsInputImpactoAmbiental = $arreglo['idsInputImpactoAmbiental'];
                $suave = $arreglo['input_ahorro_suave'];
                $duro = $arreglo['input_ahorro_duro'];
                $val[] = actualizarRegistroImpactoAmbiental($id_proyecto, $mes, $anio, $toneladas, $idsInputImpactoAmbiental, $inputImpactoAmbiental, $suave, $duro);
            } else {
                $val[] = "No llegaron todas las variables";
            }

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
} else {
    header("Location:index.php");
}
