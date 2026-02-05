<?php
include("conexionGhoner.php");

function consultarSumaPersonalizada($anio, $planta){
    global $conexion;

    $resultado = [];
    $anio = (int)$anio;

    // Base del WHERE (anio siempre aplica)
    $where  = "WHERE `year` = ?";
    $types  = "i";
    $params = [$anio];

    if ($planta !== '') {
        // Cuando planta tiene valor
        $where   .= " AND `plant` = ?";
        $types   .= "s";
        $params[] = $planta;
    } else {
        // Cuando planta viene vacía
        $where .= " AND (`plant` = '' OR `plant` IS NULL)";
    }

    $sql = "SELECT * FROM sumas_personalizadas $where ORDER BY id DESC";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return [[], false];
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    $res = $stmt->get_result();
    while ($fila = $res->fetch_assoc()) {
        $resultado[] = $fila;
    }

    return [$resultado, true];
}


    function insertarOActualizarSumaPersonalizada($proyectos, $anio, $planta) {
        global $conexion;

        // 1. Verificar si ya existe el registro
        $queryCheck = "SELECT id FROM sumas_personalizadas WHERE `year` = ? AND `plant` = ?";
        $stmtCheck = $conexion->prepare($queryCheck);
        $stmtCheck->bind_param("is", $anio, $planta);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // 2. Existe -> UPDATE
            $queryUpdate = " UPDATE sumas_personalizadas SET selected_projects = ? WHERE `year` = ? AND `plant` = ?";
            $stmt = $conexion->prepare($queryUpdate);
            $stmt->bind_param("sis", $proyectos, $anio, $planta);
        } else {
            // 3. No existe -> INSERT
            $queryInsert = "INSERT INTO sumas_personalizadas (selected_projects, year, plant) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($queryInsert);
            $stmt->bind_param("sis", $proyectos, $anio, $planta);
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