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

    // 1 Buscar registro existente
    $queryCheck = "SELECT id, selected_projects 
                   FROM sumas_personalizadas 
                   WHERE `year` = ? AND `plant` = ?";

    $stmtCheck = $conexion->prepare($queryCheck);
    $stmtCheck->bind_param("is", $anio, $planta);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {

        // 2 Ya existe
        $row = $result->fetch_assoc();
        $idRegistro = $row['id'];

        // Decodificar JSON actual
        $proyectosActuales = json_decode($row['selected_projects'], true);

        if (!is_array($proyectosActuales)) {
            $proyectosActuales = [];
        }

        // 3 Agregar nuevo ID si no existe
        if (!in_array($proyectoId, $proyectosActuales)) {
            $proyectosActuales[] = $proyectoId;
        }

        $nuevoJson = json_encode($proyectosActuales);

        // 4 Actualizar
        $queryUpdate = "UPDATE sumas_personalizadas 
                        SET selected_projects = ? 
                        WHERE id = ?";

        $stmt = $conexion->prepare($queryUpdate);
        $stmt->bind_param("si", $nuevoJson, $idRegistro);

    } else {

        // 5 No existe → crear nuevo registro
        $nuevoArray = [$proyectoId];
        $nuevoJson = json_encode($nuevoArray);

        $queryInsert = "INSERT INTO sumas_personalizadas 
                        (selected_projects, year, plant) 
                        VALUES (?, ?, ?)";

        $stmt = $conexion->prepare($queryInsert);
        $stmt->bind_param("sis", $nuevoJson, $anio, $planta);
    }

    $estado = $stmt->execute();

    $stmtCheck->close();
    $stmt->close();

    return $estado;
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