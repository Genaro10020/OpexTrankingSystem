<?php
include("conexionGhoner.php");
function consultarProyectos()
{
}

function guardarSeguimietoInicial($id_proyecto, $desde, $hasta, $toneladas, $inputImpactoAmbiental, $suave, $duro)
{
    global $conexion;
    $resultado = [];
    $error = "";
    $largo = 0;
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
            for ($i = 0; $i < $largo; $i++) {
                $id_impacto = $ids_impactos[$i]['id'];
                $datos = $inputImpactoAmbiental[$i];
                $query = "SELECT * FROM registros_impacto_ambiental WHERE id_impacto_ambiental_proyecto = ?";
                $stmt = $conexion->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("i", $id_impacto);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows <= 0) {
                        $query_insert = "INSERT INTO registros_impacto_ambiental (id_impacto_ambiental_proyecto,fecha_inicial,fecha_final,tons_co2,dato,ahorro_suave,ahorro_duro) VALUES (?,?,?,?,?,?,?)";
                        $stmt_insert = $conexion->prepare($query_insert);
                        if ($stmt_insert) {
                            $stmt_insert->bind_param("issssss", $id_impacto, $desde, $hasta, $toneladas, $datos, $suave, $duro);
                            if ($stmt_insert->execute()) {
                                $estado = true;
                            } else {
                                $estado = "No se insertó el registro: " . $id_impacto . " Todos los ides" . print_r($ids_impactos) . "ERRR" . $stmt_insert->error;
                            }

                            $stmt_insert->close();
                        } else {
                            $estado = "Error en la preparación de la consulta de inserción: " . $conexion->error;
                        }
                    }

                    $stmt->close();
                } else {
                    $estado = "Error en la preparación de la consulta: " . $conexion->error;
                }
            }

            // Después del bucle, puedes devolver solo el estado, ya que el array $ids_impactos no parece ser necesario en este contexto
            return array($estado, $ids_impactos, $id_impacto);
        } else {
            return $error = "Error en la ejecución de la consulta";
        }
    }
}


function insertarProyecto($id_proyecto)
{
}

function actualizarArea()
{
}

function eliminarArea()
{
}