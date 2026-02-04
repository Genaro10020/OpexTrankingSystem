<?php
ob_start();
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['nombre'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Sesión no válida'
    ]);
    exit;
}

include 'sumaPersonalizadaModel.php';

// Para POST / PUT
$arreglo = json_decode(file_get_contents('php://input'), true);

$val = [];

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        if (isset($_GET['anio']) && isset($_GET['planta'])) {
            $anio   = $_GET['anio'];
            $planta = $_GET['planta'];

            $data = consultarSumaPersonalizada($anio, $planta);

            $val = [
                'success'    => $data[1],
                'filtrosPor' => [
                    'anio'   => $anio,
                    'planta' => $planta
                ],
                'datos' => $data[0]
            ];
        } else {
            http_response_code(400);
            $val = [
                'success' => false,
                'mensaje' => 'Faltan parámetros'
            ];
        }
        break;

    case 'POST':
        if (
            isset($arreglo['proyectos']) &&
            isset($arreglo['anio']) &&
            isset($arreglo['planta'])
        ) {
            $proyectos     = $arreglo['proyectos'];
            $anio          = $arreglo['anio'];
            $planta        = $arreglo['planta'];
            $proyectosJson = json_encode($proyectos);

            $resultado = insertarOActualizarSumaPersonalizada(
                $proyectosJson,
                $anio,
                $planta
            );

            $val = [
                'success' => $resultado,
                'mensaje' => $resultado
                    ? 'Guardado correctamente'
                    : 'Error al guardar'
            ];
        } else {
            http_response_code(400);
            $val = [
                'success' => false,
                'mensaje' => 'Datos incompletos'
            ];
        }
        break;

    case 'PUT':
        http_response_code(405);
        $val = [
            'success' => false,
            'mensaje' => 'PUT no implementado'
        ];
        break;

    case 'DELETE':
        http_response_code(405);
        $val = [
            'success' => false,
            'mensaje' => 'DELETE no implementado'
        ];
        break;

    default:
        http_response_code(405);
        $val = [
            'success' => false,
            'mensaje' => 'Método HTTP no permitido'
        ];
        break;
}

// Limpia cualquier salida previa (espacios, warnings, includes)
ob_clean();
echo json_encode($val);
exit;