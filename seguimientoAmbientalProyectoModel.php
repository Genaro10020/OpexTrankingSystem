<?php
include("conexionGhoner.php");
function consultarProyectos()
{
}

function guardarSeguimietoInicial($id_proyecto, $mes, $anio, $toneladas, $inputImpactoAmbiental, $suave, $duro)
{
    global $conexion;
    $resultado = [];
    $error = "";
    $largo = 0;
    $existe = false;
    $id = intval($id_proyecto);
    $estado1 = false;
    $estado2 = false;
    $estado3 = false;
    $query = "SELECT id FROM impacto_ambiental_proyecto WHERE id_proyecto =?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return $estado1 = "Error en la consulta" . $conexion->error;;
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado1 = true;
            $recuperando = $stmt->get_result();
            while ($fila = $recuperando->fetch_assoc()) {
                $ids_impactos[] = $fila;
            }
            $stmt->close();
            $largo = count($ids_impactos);
            $id_impacto = 0;
            $mes = (int)$mes;
            $anio = (int)$anio;
            $mes_anio = $mes . "-" . $anio;

            $query = "SELECT registros_impacto_ambiental.mes_anio FROM  registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE impacto_ambiental_proyecto.id_proyecto = ? AND registros_impacto_ambiental.mes_anio = ?";
            $stmt = $conexion->prepare($query);
            if ($stmt) {
                $estado2 = true; 
                $stmt->bind_param("is", $id_proyecto, $mes_anio);
                $stmt->execute();
                $resultados = $stmt->get_result();
                $cantidad = $resultados->num_rows;
                $anio_mes_en_tabla = "";
                while ($row = $resultados->fetch_assoc()) {
                    $$anio_mes_en_tabla = $row['mes_anio'];
                }
                if ($resultados->num_rows > 0 || $anio_mes_en_tabla == $mes_anio) {
                    $existe = true;
                } else {
                    for ($i = 0; $i < $largo; $i++) {
                        $id_impacto = $ids_impactos[$i]['id'];
                        $datos = $inputImpactoAmbiental[$i];
                        $query_insert = "INSERT INTO registros_impacto_ambiental (id_impacto_ambiental_proyecto,mes,anio,tons_co2,mes_anio,dato,ahorro_suave,ahorro_duro) VALUES (?,?,?,?,?,?,?,?)";
                        $stmt_insert = $conexion->prepare($query_insert);
                        if ($stmt_insert) {
                            $stmt_insert->bind_param("iiisssss", $id_impacto, $mes, $anio, $toneladas, $mes_anio, $datos, $suave, $duro);
                            if ($stmt_insert->execute()) {
                                $estado3 = true;
                            } else {
                              $estado3 = false;
                              break;
                            }
                            $stmt_insert->close();
                        } else {
                            return $estado3 = "Error en la preparación de la consulta de inserción: " . $conexion->error;
                        }
                    }
                }

                $stmt->close();
            } else {
                $estado2 = "Error en la preparación de la consulta: " . $conexion->error;
            }

            // Después del bucle, puedes devolver solo el estado, ya que el array $ids_impactos no parece ser necesario en este contexto
            return array($estado1,$estado2,$estado3, $existe, $ids_impactos, $id_impacto, $cantidad, $anio_mes_en_tabla, $mes_anio);
        } else {
            $estado1 = "Error en la ejecución de la consulta";
        }
    }
}


function insertarProyecto($id_proyecto)
{
}

function actualizarRegistroImpactoAmbiental($id_proyecto, $mes, $anio, $toneladas, $idsInputImpactoAmbiental, $inputImpactoAmbiental, $suave, $duro)
{
    global $conexion;
    $id = intval($id_proyecto);
    $estado = false;
    $mes = (int)$mes;
    $anio = (int)$anio;
    $mes_anio = $mes . "-" . $anio;
    $cantidad_registro = count($idsInputImpactoAmbiental);
    $vueltas = 0;
    $existe = false;
    $query = "SELECT registros_impacto_ambiental.id AS id_registros, registros_impacto_ambiental.mes_anio FROM  registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE impacto_ambiental_proyecto.id_proyecto = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id_proyecto);
        $stmt->execute();
        $resultados = $stmt->get_result();
        $ids_que_coinciden = [];
        while ($row = $resultados->fetch_assoc()) { //recupero columnas id impacto y mes_anio de tabla registros, con anio y  id en consulta
            if ($mes_anio == $row['mes_anio']) {
                $ids_que_coinciden[] = $row['id_registros']; // tomo los ids que contiene mismo mes y anio
            }
        }
        $diferencias = array_diff($idsInputImpactoAmbiental, $ids_que_coinciden);
        if (empty($diferencias) || empty($ids_que_coinciden)) {
            $existe = false;
            for ($i = 0; $i < $cantidad_registro; $i++) {
                $id = $idsInputImpactoAmbiental[$i]; //continen los id de la tabla registros_impacto_ambiental
                $dato = $inputImpactoAmbiental[$i];

                $update = "UPDATE registros_impacto_ambiental SET mes=?,anio=?,tons_co2=?,mes_anio=?,dato=?,ahorro_suave=?,ahorro_duro=? WHERE  id=?"; //,mes_anio=? pendiente
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("iisssssi", $mes, $anio, $toneladas, $mes_anio, $dato, $suave, $duro, $id);
                if ($stmt->execute()) {
                    $estado = true;
                } else {
                    return $estado = "No se actualizo el registro: " . $stmt->error;
                }
            }
        } else {
            $existe = true;
        }
    } else {
        $estado = "Error en la preparación de la consulta: " . $conexion->error;
    }
    $stmt->close();
    return array($estado, $existe, $idsInputImpactoAmbiental, $ids_que_coinciden, $diferencias);
}

function eliminarArea()
{
}
