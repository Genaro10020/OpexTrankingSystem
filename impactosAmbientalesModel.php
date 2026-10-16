<?php

include("conexionEAD.php");

function consultarTodosImpactosAmbientales() {

    global $conexion;


    // ==========================================
    // VERIFICAR CONEXIÓN
    // ==========================================

    if (!$conexion instanceof mysqli) {
        throw new Exception(
            "La conexión a la base de datos no está disponible."
        );
    }


    // ==========================================
    // CONSULTA
    // ==========================================
    $consulta = "
        SELECT
            id,
            id_equipo,
            nombre_indicador,
            diagrama,
            tipo,
            concepto,
            alcance,
            cantidad,
            um,
            co2,
            referencia
        FROM reportes_impactos_ambientales_proyectos
        ORDER BY id ASC
    ";

    // ==========================================
    // PREPARAR CONSULTA
    // ==========================================

    $stmt = $conexion->prepare($consulta);
    if (!$stmt) {
        throw new Exception(
            "Error al preparar la consulta: " .
            $conexion->error
        );
    }


    // ==========================================
    // EJECUTAR
    // ==========================================
    if (!$stmt->execute()) {
        throw new Exception(
            "Error al consultar los impactos ambientales: " .
            $stmt->error
        );
    }


    // ==========================================
    // OBTENER RESULTADOS
    // ==========================================
    $resultado = $stmt->get_result();
    $impactos = $resultado->fetch_all(MYSQLI_ASSOC);
    // ==========================================
    // CERRAR
    // ==========================================
    $stmt->close();
    return $impactos;
}

function consultarImpactosAmbientales($nombre_indicador, $id_equipo) {
    global $conexion;
    // Consulta
    $consulta = "SELECT
            id,
            diagrama,
            tipo,
            concepto,
            alcance,
            cantidad,
            um,
            co2,
            referencia
        FROM reportes_impactos_ambientales_proyectos
        WHERE nombre_indicador = ?
        AND id_equipo = ?
        ORDER BY id ASC
    ";
    $stmt = $conexion->prepare($consulta);

    // Verificar preparación
    if (!$stmt) {
        throw new Exception(
            "Error al preparar la consulta: " . $conexion->error
        );

    }
    // Vincular parámetros
    $stmt->bind_param(
        "si",
        $nombre_indicador,
        $id_equipo
    );
    // Ejecutar
    if (!$stmt->execute()) {
        throw new Exception(
            "Error al consultar los impactos: " . $stmt->error
        );
    }
    // Obtener resultado
    $resultado = $stmt->get_result();
    // Convertir a arreglo
    $impactos = $resultado->fetch_all(MYSQLI_ASSOC);
    // Cerrar statement
    $stmt->close();
    return $impactos;
}





function guardarImpacto($datos) {

    global $conexion;

    // ============================================================
    // INCLUIR CONEXIÓN OTS
    // ============================================================

    include("conexionOTS.php");

    // Guardamos la conexión OTS en una variable independiente
    $conexionOTS = $conexion;

    // Restauramos la conexión de Ghonher
    include("conexionGhoner.php");


    // ============================================================
    // VALIDAR DATOS GENERALES
    // ============================================================

    if (!is_array($datos) || empty($datos)) {
        $conexionOTS->close();

        return [
            "status" => "error",
            "message" => "No se recibieron datos."
        ];
    }

    $nombre_indicador = trim(
        $datos['nombre_indicador'] ?? ''
    );

    $id_equipo = $datos['id_equipo'] ?? '';
    $impactos = $datos['impactos'] ?? [];

    // Validar datos generales
    if ($nombre_indicador === '' || $id_equipo === '') {
        $conexionOTS->close();

        return [
            "status" => "error",
            "message" => "Faltan datos del indicador o del equipo."
        ];
    }

    // Validar impactos
    if (!is_array($impactos)) {
        $conexionOTS->close();

        return [
            "status" => "error",
            "message" => "Los impactos ambientales no tienen un formato válido."
        ];
    }


    // ============================================================
    // INICIAR TRANSACCIÓN
    // ============================================================

    $conexion->begin_transaction();

    try {

        // ========================================================
        // 1. OBTENER LOS IDS ACTUALES DE LA BASE DE DATOS
        // ========================================================

        $consultaIds = "
            SELECT id
            FROM reportes_impactos_ambientales_proyectos
            WHERE nombre_indicador = ?
            AND id_equipo = ?
        ";

        $stmtIds = $conexion->prepare($consultaIds);

        if (!$stmtIds) {
            throw new Exception(
                "Error al preparar consulta de IDs: " .
                $conexion->error
            );
        }

        $stmtIds->bind_param(
            "si",
            $nombre_indicador,
            $id_equipo
        );

        if (!$stmtIds->execute()) {
            throw new Exception(
                "Error al consultar IDs existentes: " .
                $stmtIds->error
            );
        }

        $resultadoIds = $stmtIds->get_result();

        $idsExistentes = [];

        while ($fila = $resultadoIds->fetch_assoc()) {
            $idsExistentes[] = (int)$fila['id'];
        }

        $stmtIds->close();


        // ========================================================
        // 2. PREPARAR UPDATE
        // ========================================================

        $actualizar = "
            UPDATE reportes_impactos_ambientales_proyectos
            SET
                diagrama = ?,
                tipo = ?,
                concepto = ?,
                alcance = ?,
                cantidad = ?,
                um = ?,
                co2 = ?,
                referencia = ?
            WHERE id = ?
            AND id_equipo = ?
            AND nombre_indicador = ?
        ";

        $stmtUpdate = $conexion->prepare($actualizar);

        if (!$stmtUpdate) {
            throw new Exception(
                "Error al preparar UPDATE: " .
                $conexion->error
            );
        }


        // ========================================================
        // 3. PREPARAR INSERT
        // ========================================================

        $insertar = "
            INSERT INTO reportes_impactos_ambientales_proyectos
            (
                id_equipo,
                nombre_indicador,
                diagrama,
                tipo,
                concepto,
                alcance,
                cantidad,
                um,
                co2,
                referencia
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmtInsert = $conexion->prepare($insertar);

        if (!$stmtInsert) {
            throw new Exception(
                "Error al preparar INSERT: " .
                $conexion->error
            );
        }


        // ========================================================
        // 4. PREPARAR CONSULTA OTS
        // ========================================================

        $consultaOTS = "
            SELECT id
            FROM impacto_ambiental
            WHERE nombre = ?
            AND unidad = ?
            LIMIT 1
        ";

        $stmtOTS = $conexionOTS->prepare($consultaOTS);

        if (!$stmtOTS) {
            throw new Exception(
                "Error al preparar consulta OTS: " .
                $conexionOTS->error
            );
        }


        // ========================================================
        // 5. PREPARAR INSERT OTS
        // ========================================================

        $insertarOTS = "
            INSERT INTO impacto_ambiental
            (
                nombre,
                unidad
            )
            VALUES (?, ?)
        ";

        $stmtInsertOTS = $conexionOTS->prepare($insertarOTS);

        if (!$stmtInsertOTS) {
            throw new Exception(
                "Error al preparar INSERT OTS: " .
                $conexionOTS->error
            );
        }


        // ========================================================
        // 6. RECORRER IMPACTOS RECIBIDOS
        // ========================================================

        $idsRecibidos = [];

        $cantidadInsertados = 0;
        $cantidadActualizados = 0;
        $cantidadOTSInsertados = 0;


        foreach ($impactos as $impacto) {

            // ----------------------------------------------------
            // ID
            // ----------------------------------------------------

            $id = (
                isset($impacto['id']) &&
                $impacto['id'] !== '' &&
                $impacto['id'] !== null
            )
                ? (int)$impacto['id']
                : null;


            // ----------------------------------------------------
            // DATOS DEL IMPACTO
            // ----------------------------------------------------

            $diagrama =
                $impacto['diagrama'] ?? '';

            $tipo =
                $impacto['tipo'] ?? '';

            $concepto =
                $impacto['concepto'] ?? '';

            $alcance = (
                isset($impacto['alcance']) &&
                $impacto['alcance'] !== ''
            )
                ? (int)$impacto['alcance']
                : null;

            $cantidad = (
                isset($impacto['cantidad']) &&
                $impacto['cantidad'] !== ''
            )
                ? (float)$impacto['cantidad']
                : null;

            $um =
                $impacto['um'] ?? '';

            $co2 = (
                isset($impacto['co2']) &&
                $impacto['co2'] !== ''
            )
                ? (float)$impacto['co2']
                : null;

            $referencia =
                $impacto['referencia'] ?? '';


            // ====================================================
            // REGISTRAR EN impacto_ambiental DE OTS
            // ====================================================

            if (
                trim($concepto) !== '' &&
                trim($um) !== ''
            ) {

                $nombreOTS =
                    trim($concepto) .
                    " (" .
                    trim($um) .
                    ")";


                // ------------------------------------------------
                // VERIFICAR SI YA EXISTE
                // ------------------------------------------------

                $stmtOTS->bind_param(
                    "ss",
                    $nombreOTS,
                    $um
                );

                if (!$stmtOTS->execute()) {
                    throw new Exception(
                        "Error al verificar impacto ambiental OTS: " .
                        $stmtOTS->error
                    );
                }

                $resultadoOTS = $stmtOTS->get_result();


                // ------------------------------------------------
                // SI NO EXISTE, INSERTAR
                // ------------------------------------------------

                if ($resultadoOTS->num_rows === 0) {

                    $stmtInsertOTS->bind_param(
                        "ss",
                        $nombreOTS,
                        $um
                    );

                    if (!$stmtInsertOTS->execute()) {
                        throw new Exception(
                            "Error al insertar impacto ambiental OTS: " .
                            $stmtInsertOTS->error
                        );
                    }

                    $cantidadOTSInsertados++;
                }
            }


            // ====================================================
            // CASO 1: UPDATE
            // ====================================================

            if ($id !== null) {

                $idsRecibidos[] = $id;

                $stmtUpdate->bind_param(
                    "sssidsdsiis",
                    $diagrama,
                    $tipo,
                    $concepto,
                    $alcance,
                    $cantidad,
                    $um,
                    $co2,
                    $referencia,
                    $id,
                    $id_equipo,
                    $nombre_indicador
                );

                if (!$stmtUpdate->execute()) {
                    throw new Exception(
                        "Error al actualizar el impacto ID " .
                        $id . ": " .
                        $stmtUpdate->error
                    );
                }

                $cantidadActualizados++;
            }


            // ====================================================
            // CASO 2: INSERT
            // ====================================================

            else {

                $stmtInsert->bind_param(
                    "issssidsds",
                    $id_equipo,
                    $nombre_indicador,
                    $diagrama,
                    $tipo,
                    $concepto,
                    $alcance,
                    $cantidad,
                    $um,
                    $co2,
                    $referencia
                );

                if (!$stmtInsert->execute()) {
                    throw new Exception(
                        "Error al insertar el impacto: " .
                        $stmtInsert->error
                    );
                }

                $cantidadInsertados++;
            }
        }


        // ========================================================
        // 7. ELIMINAR IMPACTOS QUE YA NO VIENEN DEL FRONTEND
        // ========================================================

        foreach ($idsExistentes as $idExistente) {

            if (!in_array(
                $idExistente,
                $idsRecibidos,
                true
            )) {

                $eliminar = "
                    DELETE FROM reportes_impactos_ambientales_proyectos
                    WHERE id = ?
                    AND id_equipo = ?
                    AND nombre_indicador = ?
                ";

                $stmtDelete = $conexion->prepare($eliminar);

                if (!$stmtDelete) {
                    throw new Exception(
                        "Error al preparar DELETE: " .
                        $conexion->error
                    );
                }

                $stmtDelete->bind_param(
                    "iis",
                    $idExistente,
                    $id_equipo,
                    $nombre_indicador
                );

                if (!$stmtDelete->execute()) {
                    throw new Exception(
                        "Error al eliminar el impacto ID " .
                        $idExistente . ": " .
                        $stmtDelete->error
                    );
                }

                $stmtDelete->close();
            }
        }


        // ========================================================
        // 8. CERRAR STATEMENTS
        // ========================================================

        $stmtUpdate->close();
        $stmtInsert->close();
        $stmtOTS->close();
        $stmtInsertOTS->close();


        // ========================================================
        // 9. CONFIRMAR TRANSACCIÓN GHONER
        // ========================================================

        $conexion->commit();


        // ========================================================
        // 10. CERRAR CONEXIÓN OTS
        // ========================================================

        $conexionOTS->close();


        // ========================================================
        // 11. RESPUESTA
        // ========================================================

        return [
            "status" => "success",
            "message" =>
                "Impactos ambientales sincronizados correctamente.",

            "insertados" =>
                $cantidadInsertados,

            "actualizados" =>
                $cantidadActualizados,

            "eliminados" =>
                count(
                    array_diff(
                        $idsExistentes,
                        $idsRecibidos
                    )
                ),

            "impactos_ots_insertados" =>
                $cantidadOTSInsertados,

            "cantidad" =>
                $cantidadInsertados +
                $cantidadActualizados
        ];


    } catch (Exception $e) {

        $conexion->rollback();

        if ($conexionOTS) {
            $conexionOTS->close();
        }

        return [
            "status" => "error",
            "message" => $e->getMessage()
        ];
    }
}



function eliminarImpacto($datos) {
    global $conexion;

    $id = $datos['id'] ?? '';
    $id_equipo = $datos['id_equipo'] ?? '';
    $nombre_indicador = $datos['nombre_indicador'] ?? '';


    // ==========================================
    // VALIDAR DATOS
    // ==========================================

    if (empty($id) || empty($id_equipo) || empty($nombre_indicador)) {
        return [
            "status" => "error",
            "message" => "Faltan datos para eliminar el impacto ambiental."
        ];
    }


    // ==========================================
    // CONSULTA DELETE
    // ==========================================

    $consulta = "
        DELETE FROM reportes_impactos_ambientales_proyectos
        WHERE id = ?
        AND id_equipo = ?
        AND nombre_indicador = ?
    ";


    // ==========================================
    // PREPARAR
    // ==========================================

    $stmt = $conexion->prepare($consulta);


    if (!$stmt) {

        return [
            "status" => "error",
            "message" =>
                "Error al preparar la eliminación: " .
                $conexion->error
        ];

    }


    // ==========================================
    // VINCULAR
    // ==========================================

    $stmt->bind_param(
        "iis",
        $id,
        $id_equipo,
        $nombre_indicador
    );


    // ==========================================
    // EJECUTAR
    // ==========================================

    if (!$stmt->execute()) {
        $error = $stmt->error;
        $stmt->close();
        return [
            "status" => "error",
            "message" =>
                "Error al eliminar el impacto: " .
                $error
        ];

    }


    // ==========================================
    // VERIFICAR ELIMINACIÓN
    // ==========================================
    if ($stmt->affected_rows === 0) {
        $stmt->close();
        return [
            "status" => "error",
            "message" =>
                "No se encontró el impacto ambiental con ID " .
                $id . "."
        ];
    }


    // ==========================================
    // CERRAR
    // ==========================================
    $stmt->close();


    // ==========================================
    // RESPUESTA
    // ==========================================
    return [
        "status" => "success",
        "message" => "Impacto ambiental eliminado correctamente.",
        "id" => $id
    ];
}

?>