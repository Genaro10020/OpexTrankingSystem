<?php

session_start();

if (isset($_SESSION['nombre'])) {

    header('Content-Type: application/json; charset=utf-8');
    // Obtener datos enviados desde Vue/Axios
    $arreglo = json_decode(file_get_contents('php://input'), true);
    include("impactosAmbientalesModel.php");
    $resultado = null;
    switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':

        $accion = $_GET['accion'] ?? '';


        // =====================================================
        // CONSULTAR TODOS LOS IMPACTOS AMBIENTALES
        // =====================================================

        if ($accion === 'consultarTodos') {
            try {

                $impactos = consultarTodosImpactosAmbientales();

                $resultado = [
                    "status" => "success",
                    "impactos" => $impactos,
                    "cantidad" => count($impactos)
                ];

            } catch (Exception $e) {

                $resultado = [
                    "status" => "error",
                    "message" => "Error al consultar todos los impactos ambientales.",
                    "error" => $e->getMessage()
                ];

            }
            break;
        }

        // =====================================================
        // CONSULTAR IMPACTOS DE UN KPI
        // =====================================================
        if ($accion === 'consultarImpactosProyectoEAD') {
            $nombre_indicador = $_GET['nombre_indicador'] ?? '';
            $id_equipo = $_GET['id_equipo'] ?? '';
            // Validar parámetros
            if (empty($nombre_indicador) || empty($id_equipo)) {
                $resultado = [
                    "status" => "error",
                    "message" => "Faltan parámetros para consultar los impactos ambientales."
                ];
                break;
            }
            try {

                $impactos = consultarImpactosAmbientales(
                    $nombre_indicador,
                    $id_equipo
                );

                $resultado = [
                    "status" => "success",
                    "nombre_indicador" => $nombre_indicador,
                    "id_equipo" => $id_equipo,
                    "impactos" => $impactos,
                    "cantidad" => count($impactos)
                ];
            } catch (Exception $e) {
                $resultado = [
                    "status" => "error",
                    "message" => "Error al consultar los impactos ambientales.",
                    "error" => $e->getMessage()
                ];
            }
            break;
        }

        // =====================================================
        // ACCIÓN NO RECONOCIDA
        // =====================================================

        $resultado = [
            "status" => "error",
            "message" => "No se especificó una acción de consulta válida."
        ];
        break;

            case 'POST':

                if (!empty($arreglo) && is_array($arreglo)) {
                    $resultado = guardarImpacto($arreglo);
                } else {

                    $resultado = [
                        "status" => "error",
                        "message" => "No se recibieron datos."
                    ];
                }

                break;
        case 'PUT':
            $resultado = [
                "status" => "error",
                "message" => "Método PUT no implementado."
            ];
            break;
        case 'DELETE':
                if (!empty($arreglo) &&is_array($arreglo)) {
                    $resultado = eliminarImpacto($arreglo);
                } else {
                    $resultado = [
                        "status" => "error",
                        "message" => "No se recibieron datos para eliminar."
                    ];
                }
        break;
        default:
            $resultado = [
                "status" => "error",
                "message" => "Método HTTP no permitido."
            ];
            break;
    }

    // Regresar respuesta JSON
    echo json_encode($resultado);

} else {
    header("Location:index.php");
    exit;

}

?>