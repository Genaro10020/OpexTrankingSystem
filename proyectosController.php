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
                    $planta=$_GET['planta'];
                    //$val[] = 'Hola'.$anio;
                    $val[] = consultarCalendarioProyecto($anio,$planta);
                }
                if($_GET['accion']=='sumar valores'){
                    $val[] = sumaValoresGonher();
                }
                if($_GET['accion']=='consulta Global'){
                    $anio=$_GET['anio'];
                    //$val[] = 'Hola'.$anio;
                    $val[] = consultarProyectosPorAnioSelected($anio);
                }

            }else {
                $val[] = consultarProyectos();
            }
 
            break;
        case 'POST':
            if (isset($arreglo['folio']) || isset($arreglo['accion'])) {
                $folio = $arreglo['folio'] ?? '';

                $fecha_alta = $arreglo['fecha_alta'] ?? '';
                $separando = explode("-", $fecha_alta);
                $fecha_alta_invertida = isset($separando[2]) ? $separando[2] . "-" . $separando[1] . "-" . $separando[0] : '';

                $nombre_proyecto = $arreglo['nombre_proyecto'] ?? '';
                $fuente = $arreglo['fuente'] ?? '';
                $planta = $arreglo['select_planta'] ?? '';
                $area = $arreglo['select_area'] ?? '';
                $departamento = $arreglo['select_departamento'] ?? '';
                $metodologia = $arreglo['select_metodologia'] ?? '';
                $responsable_id = $arreglo['responsable_id'] ?? '';
                $observador = $arreglo['observador'] ?? [];
                $misiones = $arreglo['misiones'] ?? [];
                $pilares = $arreglo['pilares'] ?? [];
                $objetivos = $arreglo['objetivos'] ?? [];
                $impacto_ambiental = $arreglo['impacto_ambiental'] ?? [];
                $impacto_ambiental_emisiones = $arreglo['impacto_ambiental_emisiones'] ?? [];
                $valores = $arreglo['valores'] ?? [];
                $tons_co2 = $arreglo['tons_co2'] ?? 0;
                if ($tons_co2 == "") { $tons_co2 = 0; }

                $ahorro_duro = $arreglo['ahorro_duro'] ?? '$.00';
                $ahorro_suave = $arreglo['ahorro_suave'] ?? '$.00';

                $idsPlanMesual = $arreglo['idsPlanMesual'] ?? [];
                $anioXmes = $arreglo['anioXmes'] ?? [];
                $mesXAnio = $arreglo['mesXAnio'] ?? [];
                $valoresMensualCO = $arreglo['valoresMensualCO'] ?? [];
                $valoresMensualAD = $arreglo['valoresMensualAD'] ?? [];
                $valoresMensualAS = $arreglo['valoresMensualAS'] ?? [];
                $presupuestado = $arreglo['presupuestado'] ?? '';
                $mesesPresupuestados = $arreglo['mesesPresupuestados'] ?? [];

                $diagrama_proceso = $arreglo['diagrama_proceso'] ?? [];
                $tipo = $arreglo['tipo'] ?? [];
                $cantidad = $arreglo['cantidad'] ?? [];
                $referencia = $arreglo['referencia'] ?? [];
                $id_eads = $arreglo['id_eads'];
                $impactos_completos = $arreglo['impactos_completos'] ?? []; 
                
                $misiones = json_encode($misiones, JSON_UNESCAPED_UNICODE);
                $observador = json_encode($observador, JSON_UNESCAPED_UNICODE);
                $pilares = json_encode($pilares, JSON_UNESCAPED_UNICODE);
                $objetivos = json_encode($objetivos, JSON_UNESCAPED_UNICODE);
                $impacto_ambiental = json_encode($impacto_ambiental, JSON_UNESCAPED_UNICODE);
                $impacto_ambiental_emisiones = json_encode($impacto_ambiental_emisiones, JSON_UNESCAPED_UNICODE);
                $valores = json_encode($valores, JSON_UNESCAPED_UNICODE);
                $idsPlanMesual = json_encode($idsPlanMesual, JSON_UNESCAPED_UNICODE);
                $anioXmes = json_encode($anioXmes, JSON_UNESCAPED_UNICODE);
                $mesXAnio = json_encode($mesXAnio, JSON_UNESCAPED_UNICODE);
                $valoresMensualCO = json_encode($valoresMensualCO, JSON_UNESCAPED_UNICODE);
                $valoresMensualAD = json_encode($valoresMensualAD, JSON_UNESCAPED_UNICODE);
                $valoresMensualAS = json_encode($valoresMensualAS, JSON_UNESCAPED_UNICODE);
                $mesesPresupuestados = json_encode($mesesPresupuestados, JSON_UNESCAPED_UNICODE);
                
                $diagrama_proceso = json_encode($diagrama_proceso, JSON_UNESCAPED_UNICODE);
                $tipo = json_encode($tipo, JSON_UNESCAPED_UNICODE);
                $cantidad = json_encode($cantidad, JSON_UNESCAPED_UNICODE);
                $referencia = json_encode($referencia, JSON_UNESCAPED_UNICODE);
                $id_eads = json_encode($id_eads, JSON_UNESCAPED_UNICODE);

                if($arreglo['accion'] == "Alta Proyecto"){
                    $val[] = insertarProyecto(
                        $folio, $fecha_alta_invertida, $nombre_proyecto, $fuente, $planta, $area, 
                        $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, 
                        $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, 
                        $tons_co2, $ahorro_duro, $ahorro_suave, $anioXmes, $mesXAnio, $valoresMensualCO, 
                        $valoresMensualAD, $valoresMensualAS, $presupuestado, $mesesPresupuestados, 
                        $diagrama_proceso, $tipo, $cantidad, $referencia, $id_eads, $impactos_completos
                    );
                } else if($arreglo['accion'] == "Actualizar Proyecto"){
                    if(isset($arreglo['id_actualizar'])){
                        $id = $arreglo['id_actualizar'];
                        $val[] = actualizarProyecto(
                            $id, $folio, $fecha_alta_invertida, $nombre_proyecto, $fuente, $planta, $area, 
                            $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, 
                            $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, 
                            $anioXmes, $mesXAnio, $valoresMensualCO, $valoresMensualAD, $valoresMensualAS, 
                            $idsPlanMesual, $presupuestado, $mesesPresupuestados, 
                            $diagrama_proceso, $tipo, $cantidad, $referencia, $impactos_completos
                        );
                    } else {
                        $val[] = "No llego el ID proyecto actualizar";
                    }
                } else {
                    $val[] = "No exista esa acción en insertar o actualizar proyecto";
                }
            } else if (isset($arreglo['id_proyecto'])) {
                $id_proyecto = $arreglo['id_proyecto'];
                $val[] = consultarProyectosID($id_proyecto);
            } else {
                $val[] = "No llegaron todas las variables";
            } 
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
            }else if($arreglo['accion']=="Guardar Rechazo"){
                if (isset($arreglo['id_proyecto']) && isset($arreglo['status_rechazo']) && isset($arreglo['motivo']) && isset($arreglo['anio']) && isset($arreglo['mes'])){
                    $id_proyecto = $arreglo['id_proyecto'];
                    $status_rechazo = $arreglo['status_rechazo'];
                    $motivo = $arreglo['motivo'];
                    $anio = $arreglo['anio'];
                    $mes = $arreglo['mes'];
                    $val[] = actualizarRechazo($id_proyecto,$status_rechazo,$motivo,$anio,$mes);
                }else{
                    $val[] = "No llegaron todas la variables para Guardar Rechazo";
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
    session_destroy();
    header("Location:index.php");
}
