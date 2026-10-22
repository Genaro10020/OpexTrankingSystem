<?php
include("conexionGhoner.php");

function consultarSumaPersonalizada($anio, $planta){
    global $conexion;

    $resultado = [];
    $anio = (int)$anio;

    $sql = "SELECT * FROM sumas_personalizadas WHERE `year` = ? AND ( ? = '' OR `plant` = ? ) ORDER BY id DESC";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return [[], false];
    }

    $stmt->bind_param("iss", $anio, $planta, $planta);
    $stmt->execute();

    $res = $stmt->get_result();
    while ($fila = $res->fetch_assoc()) {
        $resultado[] = $fila;
    }

    return [$resultado, true];
}


  
function insertarOActualizarSumaPersonalizada($proyectoId, $anio, $planta) {
    global $conexion;

    // Normalizar el ID para evitar diferencias entre "15" y 15
    $proyectoId = (string)$proyectoId;

    $queryCheck = "SELECT id, selected_projects
                   FROM sumas_personalizadas
                   WHERE `year` = ? AND `plant` = ?
                   LIMIT 1";

    $stmtCheck = $conexion->prepare($queryCheck);
    $stmtCheck->bind_param("is", $anio, $planta);

    if (!$stmtCheck->execute()) {
        error_log("Error SELECT: " . $stmtCheck->error);
        $stmtCheck->close();
        return false;
    }

    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {

        // Ya existe un registro para ese año y planta
        $row = $result->fetch_assoc();
        $idRegistro = (int)$row['id'];

        $proyectosActuales = json_decode(
            $row['selected_projects'],
            true
        );

        if (!is_array($proyectosActuales)) {
            $proyectosActuales = [];
        }

        // Normalizar los IDs existentes
        $proyectosActuales = array_map(
            'strval',
            $proyectosActuales
        );

        // Buscar si el proyecto ya está seleccionado
        $indice = array_search(
            $proyectoId,
            $proyectosActuales,
            true
        );

        if ($indice !== false) {
            // Ya existe: quitarlo
            unset($proyectosActuales[$indice]);
            $accion = "eliminado";
        } else {
            // No existe: agregarlo
            $proyectosActuales[] = $proyectoId;
            $accion = "agregado";
        }

        // Reindexar el arreglo antes de convertirlo a JSON
        $nuevoJson = json_encode(
            array_values($proyectosActuales)
        );

        $queryUpdate = "UPDATE sumas_personalizadas
                        SET selected_projects = ?
                        WHERE id = ?";

        $stmt = $conexion->prepare($queryUpdate);
        $stmt->bind_param("si", $nuevoJson, $idRegistro);

    } else {

        // No existe registro para ese año y planta:
        // crear uno con el proyecto seleccionado
        $nuevoJson = json_encode([$proyectoId]);
        $accion = "agregado";

        $queryInsert = "INSERT INTO sumas_personalizadas
                        (selected_projects, `year`, `plant`)
                        VALUES (?, ?, ?)";

        $stmt = $conexion->prepare($queryInsert);
        $stmt->bind_param("sis", $nuevoJson, $anio, $planta);
    }

    $estado = $stmt->execute();

    if (!$estado) {
        error_log("Error guardando suma personalizada: " . $stmt->error);
    }

    $stmt->close();
    $stmtCheck->close();

    return $estado ? $accion : false;
}

/* 
    function actualizarMetodologia($id,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE metodologias SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarMetodologia($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM metodologias WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    } */
?>