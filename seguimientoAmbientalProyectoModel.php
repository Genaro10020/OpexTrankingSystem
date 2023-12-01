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
    $estado = false;
    $query = "SELECT id FROM impacto_ambiental_proyecto WHERE id_proyecto =?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return $error = "Error en la consulta" . $conexion->error;;
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado = true;
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

            $query = "SELECT * FROM registros_impacto_ambiental WHERE mes_anio = ?";
            $stmt = $conexion->prepare($query);
            if ($stmt) {
                $stmt->bind_param("s", $mes_anio);
                $stmt->execute();
                $resultados=$stmt->get_result();
                $arreglo = array();
                while($row=$resultados->fetch_assoc()) {
                    $arreglo = $row['mes_anio'];
                }
                $cantidad = $stmt->num_rows;
                if ( $arreglo==$mes_anio){ 
                    $existe= true;
                }else{
                    for ($i = 0; $i < $largo; $i++) {
                        $id_impacto = $ids_impactos[$i]['id'];
                        $datos = $inputImpactoAmbiental[$i];

                                        $query_insert = "INSERT INTO registros_impacto_ambiental (id_impacto_ambiental_proyecto,mes,anio,tons_co2,mes_anio,dato,ahorro_suave,ahorro_duro) VALUES (?,?,?,?,?,?,?,?)";
                                        $stmt_insert = $conexion->prepare($query_insert);
                                        if ($stmt_insert) {
                                            $stmt_insert->bind_param("iiisssss", $id_impacto, $mes, $anio, $toneladas, $mes_anio, $datos, $suave, $duro);
                                            if ($stmt_insert->execute()) {
                                                $estado = true;
                                            } else {
                                                $estado = "No se inserto el registro: " . $id_impacto . " Todos los ides" . print_r($ids_impactos) . "ERRR" . $stmt_insert->error;
                                            }
        
                                            $stmt_insert->close();
                                        } else {
                                            $estado = "Error en la preparación de la consulta de inserción: " . $conexion->error;
                                        }
                    }
                }

                $stmt->close();
            } else {
                $estado = "Error en la preparación de la consulta: " . $conexion->error;
            }

            // Después del bucle, puedes devolver solo el estado, ya que el array $ids_impactos no parece ser necesario en este contexto
            return array($estado, $ids_impactos, $id_impacto, $existe);
        } else {
            return $error = "Error en la ejecución de la consulta";
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
        $stmt->close();
    }

    return array($estado, $vueltas);
}

function eliminarArea()
{
}
