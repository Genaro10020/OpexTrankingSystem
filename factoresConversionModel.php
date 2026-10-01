<?php
include("conexionGhoner.php");

function consultarFactoresConversion()
{
    global $conexion;

    $sql = "SELECT * FROM factores_conversion";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        return false;
    }

    $factores = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $factores[] = $fila;
    }

    return $factores;
}


function crearFactorConversion($factor)
{
    global $conexion;
    $sql = "INSERT INTO factores_conversion (unidad, unidad_medida, valor, um_poder_calorifico) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "isds", $factor['unidad'], $factor['unidad_medida'], $factor['valor'], $factor['um_poder_calorifico']);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $id = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    return $id;
}

function actualizarFactorConversion($factor)
{
    global $conexion;
    $sql = "UPDATE factores_conversion
            SET unidad = ?,
                unidad_medida = ?,
                valor = ?,
                um_poder_calorifico = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isdsi",
        $factor['unidad'],
        $factor['unidad_medida'],
        $factor['valor'],
        $factor['um_poder_calorifico'],
        $factor['id']
    );

    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $resultado;
}
?>
