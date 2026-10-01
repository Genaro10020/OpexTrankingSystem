<?php
session_start();

if (isset($_SESSION['nombre'])) {
    include 'combustiblesModel.php';
    header('Content-Type: application/json');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $resultado = consultarCombustibles();

            if ($resultado !== false) {
                $val = ["status" => true, "resultado" => $resultado];
            } else {
                $val = ["status" => false, "resultado" => []];
            }
            break;

       case 'POST':
            $datos = json_decode(file_get_contents("php://input"), true);
            if (!isset($datos['combustible'])) {
                $val = ["status" => false, "mensaje" => "No se recibieron los datos del combustible"];
                break;
            }
            $combustible = $datos['combustible'];
            $resultado = actualizarCombustible($combustible);
            if (isset($resultado['error'])) {
                $val = [
                    "status" => false,
                    "mensaje" => $resultado['error']
                ];
            } else {
                $val = [
                    "status" => true,
                    "mensaje" => "Combustible actualizado correctamente",
                    "resultado" => $resultado
                ];
            }
     break;


        default:
            http_response_code(405);
            $val = ["status" => false, "mensaje" => "Método HTTP no permitido"];
            break;
    }

    echo json_encode($val);
} else {
    header("Location:index.php");
}
?>
