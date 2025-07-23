<?php
include("conexionGhoner.php");
/*function consultarProyectos()
{
    global $conexion;
    $resultado = [];
    $estado = false;
    $consulta = "SELECT * FROM proyectos_creados ORDER BY folio ASC";
    $query = $conexion->query($consulta);
    if ($query) {
        while ($datos = mysqli_fetch_array($query)) {
            $resultado[] = $datos;
        }
        $estado  = true;
    } else {
        $estado  = false;
    }
    return array($resultado, $estado);
}*/

function consultarCapturaTotalMesesXProyectoXAnio($idsProyectos){
    global $conexion;
    $error = "";
    $estado = false;
     $resultado = [];
    $arreglo = [];
    foreach ($idsProyectos as $key => $value) {
    $query = "SELECT registros.id AS id_registro, proyectos_creados.id AS idProyecto, impactos.id AS id_impacto, registros.*, impactos.*, proyectos_creados.status_seguimiento  
    FROM impacto_ambiental_proyecto AS impactos 
    INNER JOIN proyectos_creados ON impactos.id_proyecto = proyectos_creados.id/*Agregue esta para consultar status_seguimiento*/
    INNER JOIN registros_impacto_ambiental registros  ON  impactos.id = registros.id_impacto_ambiental_proyecto 
    WHERE impactos.id_proyecto = ? GROUP BY mes_anio ORDER BY registros.anio, registros.mes ASC";//AGRUPO LOS PROYECTO EXISTENTES
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return $error = "Error en la consulta" . $conexion->error;;
    } else {
        $stmt->bind_param("i", $value);
        if ($stmt->execute()) {
            $estado = true;
            $recuperando = $stmt->get_result();
           
          while ($fila = $recuperando->fetch_assoc()) {
                $idProyecto = $fila['idProyecto'];
                $mesRegistro = $fila['mes'];
                $anioRegistro = $fila['anio'];

                // Elimina el símbolo de moneda ($) y las comas (,), luego convierte a float
                $ahorroDuro = str_replace([',', '$'], '', $fila['ahorro_duro']);
                $ahorroDuro = floatval($ahorroDuro);

                // Depuración: muestra el valor antes de almacenarlo
               // echo "idProyecto: $idProyecto, Ahorro Duro: $ahorroDuro<br>";
                $mesANio = [
                            "mes"=>$mesRegistro,
                            "anio"=>$anioRegistro,
                            "ahorroDuro"=> "$" . number_format($ahorroDuro, 2, '.', ',')
                        ];

                // Verifica si ya existe un registro para este 'idProyecto'
                if (!isset($resultado[$idProyecto])) {
                    // Si no existe, inicializa la clave 'sumaTotal' con el valor de 'ahorro_duro'
                    $resultado[$idProyecto]['registros'][] = $mesANio;
                    $resultado[$idProyecto]['sumaTotal'] = $ahorroDuro;
                } else {
                    // Si ya existe, suma el valor de 'ahorro_duro' al total existente
                    $resultado[$idProyecto]['sumaTotal'] += $ahorroDuro;
                    $resultado[$idProyecto]['registros'][] = $mesANio;
                }
                // Actualiza la cantidad de meses capturados
                $resultado[$idProyecto]['mesesCapturados'] = count($resultado[$idProyecto]['registros']);
            }
            $stmt->close();
        } else {
            return $error = "Error en la ejecución de la consulta";
        }
    }
    }

    return array($resultado);
    

}

function consultarImpactosXproyectoID($id_proyecto)
{
    global $conexion;
    $resultado = [];
    $resultado2 = [];
    $error = "";
    $id = (int)$id_proyecto;
    $estado1 = false;
    $estado2 = false;
    //consulta mes_inio distintos solo una fila por registro diferente
    $query = "SELECT registros.id AS id_registro, impactos.id AS id_impacto, registros.*, impactos.*, proyectos_creados.status_seguimiento, proyectos_creados.impacto_ambiental  FROM impacto_ambiental_proyecto impactos 
    INNER JOIN proyectos_creados ON impactos.id_proyecto = proyectos_creados.id/*Agregue esta para consultar status_seguimiento*/
    INNER JOIN registros_impacto_ambiental registros  ON  impactos.id = registros.id_impacto_ambiental_proyecto 
    WHERE impactos.id_proyecto = ? GROUP BY mes_anio ORDER BY registros.anio, registros.mes ASC";//AGRUPO LOS PROYECTO EXISTENTES
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        return $error = "Error en la consulta" . $conexion->error;
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado1 = true;
            $recuperando = $stmt->get_result();
            while ($fila = $recuperando->fetch_assoc()) {
                $resultado[] = $fila;
            }
            $stmt->close();
        } else {
            return $error = "Error en la ejecución de la consulta";
        }
    }
    //obteniendo impactos ambientales con sus datos
    $query = "SELECT registros.id AS id_registro, impactos.id AS id_impacto, registros.dato, impactos.impacto_ambiental, registros.mes_anio FROM impacto_ambiental_proyecto impactos  
    JOIN  registros_impacto_ambiental registros  
    ON  impactos.id = registros.id_impacto_ambiental_proyecto
    WHERE impactos.id_proyecto = ? ORDER BY registros.anio, registros.mes ASC";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return $error = "Error en la consulta impactos ambiental con sus datos " . $conexion->error;;
    } else {
        $resultado2 = array();
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado2 = true;
            $recuperando = $stmt->get_result();
            $posicion = "";
            $posiciones_por_mes_anio = array();
            while ($fila = $recuperando->fetch_assoc()) {
                $mes_anio = $fila['mes_anio'];
                // Verificar si ya hay una posición para este mes_anio
                if (isset($posiciones_por_mes_anio[$mes_anio])) {
                    $posicion = $posiciones_por_mes_anio[$mes_anio];
                } else {
                    // Si no hay una posición, crea una nueva y guarda la relación
                    $posicion = count($resultado2);
                    $posiciones_por_mes_anio[$mes_anio] = $posicion;
                    $resultado2[$posicion] = array();
                }

                // Agregar fila al subarreglo correspondiente al mes_anio
                $resultado2[$posicion][] = $fila;
            }
            $stmt->close();
        } else {
            return $error = "Error en la ejecución de la consulta";
        }
    }



    return array($resultado, $estado1, $resultado2, $estado2, $id_proyecto, $error);
}


function insertarProyecto()
{
}

function actualizarArea()
{
}

function eliminarArea()
{
}
