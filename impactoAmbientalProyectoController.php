<?php
session_start();
if (isset($_SESSION['nombre'])) {
    include 'impactoAmbientalProyectoModel.php';
    $arreglo = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    $val = [];

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['accion']) && $_GET['accion']=='ConsultarCapturasProyecto'){
                $idsProyectos=$_GET['idsProyectos'];
               $val[]  = consultarCapturaTotalMesesXProyectoXAnio($idsProyectos);
            }else{
                 $val[] = "NO llegaron: ";
            }
            // Manejar solicitud GET (consultar)

            break;
        case 'POST':
            // Manejar solicitud POST (creación)
            if (isset($arreglo['id_proyecto'])) {
                $id_proyecto = $arreglo['id_proyecto'];
                $val[] = consultarImpactosXproyectoID($id_proyecto);
            }
            // ...
            break;
        case 'PUT':
            // Manejar solicitud PUT (actualización)

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
