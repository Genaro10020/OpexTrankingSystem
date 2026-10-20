<?php

session_start();

if (isset($_SESSION['nombre'])) {

    include 'impactosAmbientalesModelOTS.php';

    header('Content-Type: application/json; charset=utf-8');

    $val = [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['accion']) && $_GET['accion'] === 'impactosAmbientalesOTS') {
                $resultado = consultarImpactoAmbiental();
                echo json_encode([
                    'status' => $resultado[1] ? 'success' : 'error',
                    'impactos' => $resultado[0]
                ]);
                exit;
            }
            if (isset($_GET['accion']) && $_GET['accion'] === 'calculadorafe') {
                $resultado = consultarCalculadorafe();
                echo json_encode([
                    'status' => $resultado[1] ? 'success' : 'error',
                    'calcFe' => $resultado[0]
                ]);
                exit;
            }
            if (isset($_GET['accion']) && $_GET['accion'] === 'factoresConversion') {
                $resultado = consultarFactoresConversion();
                echo json_encode([
                    'status' => $resultado[1] ? 'success' : 'error',
                    'factoresConversion' => $resultado[0]
                ]);
                exit;
            }

            $val[] = [
                'status' => 'error',
                'message' => 'No existe la variable accion'
            ];
            break;
        case 'POST':

       
        case 'PUT':

            break;
        case 'DELETE':
   
        default:
            http_response_code(405);
            $val[] = [
                'status' => 'error',
                'message' => 'Método HTTP no permitido'
            ];

            break;
    }
    echo json_encode($val);
} else {
    session_destroy();
    header("Location:index.php");
}
