<?php
include("conexionGhoner.php");

function consultarCombustibles()
{
    global $conexion;
    $sql = "SELECT * FROM calculadora_fe_combustibles_energeticos";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        return false;
    }
    $combustibles = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $combustibles[] = $fila;
    }
    return $combustibles;
}

function actualizarCombustible($combustible)
{
    global $conexion;

    if (!isset($combustible['id'])) {
        return ["error" => "No se recibió el ID del combustible"];
    }

    $id = $combustible['id'];
    $unidad_nombre = $combustible['unidad_nombre'] ?? '';
    $da_um = $combustible['um'] ?? '';
    $poder_calorifico = $combustible['poderCalorifico'] ?? '';
    $poder_calorifico_um = $combustible['unidadPC_um'] ?? '';
     $conversion_poder_calorifico_unidad = $combustible['unidadPCConvertido'] ?? '';

    $factor_emision_co2_t_mj = $combustible['co2'] ?? 0;
    $factor_emision_ch4_kg_mj = $combustible['ch4'] ?? 0;
    $factor_emision_n2o_kg_mj = $combustible['n2o'] ?? 0;

    $potencial_calentamiento_c02 = $combustible['pcgCO2'] ?? 0;
    $potencial_calentamiento_ch4 = $combustible['pcgCH4'] ?? 0;
    $potencial_calentamiento_n2o = $combustible['pcgN2O'] ?? 0;
    $fuente_oficial = $combustible['fuente'] ?? '';

    $sql = "UPDATE calculadora_fe_combustibles_energeticos SET
                unidad_nombre = ?,
                da_um = ?,
                poder_calorifico = ?,
                poder_calorifico_um = ?,
                conversion_poder_calorifico_unidad = ?,
                factor_emision_co2_t_mj = ?,
                factor_emision_ch4_kg_mj = ?,
                factor_emision_n2o_kg_mj = ?,
                potencial_calentamiento_c02 = ?,
                potencial_calentamiento_ch4 = ?,
                potencial_calentamiento_n2o = ?,
                fuente_oficial = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    if (!$stmt) {
        return ["error" => "Error en prepare: " . mysqli_error($conexion)];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssissdddiiisi",
        $unidad_nombre,
        $da_um,
        $poder_calorifico,
        $poder_calorifico_um,
        $conversion_poder_calorifico_unidad,
        $factor_emision_co2_t_mj,
        $factor_emision_ch4_kg_mj,
        $factor_emision_n2o_kg_mj,
        $potencial_calentamiento_c02,
        $potencial_calentamiento_ch4,
        $potencial_calentamiento_n2o,
        $fuente_oficial,
        $id
    );

    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        return ["error" => "Error en execute: " . $error];
    }

    $afectados = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return [
        "actualizado" => true,
        "filas_afectadas" => $afectados
    ];
}

?>
