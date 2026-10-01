<?php
session_start();

if (isset($_SESSION['nombre'])) {
    include 'factoresConversionModel.php';
    header('Content-Type: application/json');
    $arreglo = json_decode(file_get_contents('php://input'), true);
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $resultado = consultarFactoresConversion();

            if ($resultado !== false) {
                $val = [
                    "status" => true,
                    "resultado" => $resultado
                ];
            } else {
                $val = [
                    "status" => false,
                    "resultado" => []
                ];
            }
            break;

        case 'POST':
               
                if (!$arreglo) {
                    $val = ["status" => false, "mensaje" => "No se recibieron datos para agregar."];
                    break;
                }
                $resultado = crearFactorConversion($arreglo);

                if ($resultado !== false) {
                    $val = [
                        "status" => true,
                        "mensaje" => "Factor de conversión agregado correctamente.",
                        "id" => $resultado
                    ];
                } else {
                    $val = [
                        "status" => false,
                        "mensaje" => "No se pudo agregar el factor de conversión."
                    ];
                }
                break;


        case 'PUT':
         

            if (!$arreglo) {
                $val = [
                    "status" => false,
                    "mensaje" => "No se recibieron datos para actualizar."
                ];
                break;
            }

            $resultado = actualizarFactorConversion($arreglo);

            if ($resultado) {
                $val = [
                    "status" => true,
                    "mensaje" => "Factor de conversión actualizado correctamente."
                ];
            } else {
                $val = [
                    "status" => false,
                    "mensaje" => "No se pudo actualizar el factor de conversión."
                ];
            }
            break;

        case 'DELETE':
            $val = [
                "status" => false,
                "mensaje" => "Método DELETE no implementado"
            ];
            break;

        default:
            http_response_code(405);
            $val = [
                "status" => false,
                "mensaje" => "Método HTTP no permitido"
            ];
            break;
    }

    echo json_encode($val);
} else {
    header("Location:index.php");
}
?>
