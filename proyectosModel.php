<?php
include("conexionGhoner.php");
function consultarProyectos()
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

    $estado2 = false;
    $sumaTons = 0;
    $sumaDuro = 0;
    $sumaSuave = 0;
    $valor1 = 0;
    $valor2  = 0;
    $valor3  = 0;
    $id = null;
    $nombre = 0;
    $sumando = '';
    $checando = [];
    $sumasXProyecto = array();
    $ids = '';
    $doce_vueltas = 0;
    $todaslasvueltas = 0;
    $query = "SELECT impacto_ambiental_proyecto.id_proyecto, proyectos_creados.id, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.id_impacto_ambiental_proyecto, registros_impacto_ambiental.tons_co2, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.ahorro_suave FROM impacto_ambiental_proyecto 
    INNER JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id
    INNER JOIN registros_impacto_ambiental ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto  ORDER BY  proyectos_creados.id, registros_impacto_ambiental.id_impacto_ambiental_proyecto  ASC"; //AGRUPO LOS PROYECTO EXISTENTES
    if ($datos = $conexion->query($query)) {
        $estado2 = true;
        $ultimaFila = $datos->num_rows;
        while ($fila = $datos->fetch_assoc()) {;
            $todaslasvueltas++;


            if ($id === null) { // entrara solo una vez
                $id = $fila['id'];
                $sumasXProyecto[$id] = array();
                $nombre = $fila['nombre_proyecto'];


                $valor1 = (float)$fila['tons_co2'];
                $sumaTons += $valor1;
                // Eliminar el sigono de "$" y las comas y convertir a float
                $valor2 = (float)str_replace(['$', ','], '', $fila['ahorro_duro']);
                $sumaDuro += $valor2;
                $valor3 = (float)str_replace(['$', ','], '', $fila['ahorro_suave']);
                $sumaSuave += $valor3;
                $sumando .= " " . $fila['tons_co2'];
                $ids .= "nulo" . $fila['id'];
            } else { // despues comparara id
                if ($id != $fila['id']) { //cuando sea distinto al id anterior se insertara y se receteraran las variables
                    $doce_vueltas = 1;
                    $sumaTons = number_format($sumaTons, 2, '.', ',');
                    $sumaDuro = "$" . number_format($sumaDuro, 2, '.', ',');
                    $sumaSuave = "$" . number_format($sumaSuave, 2, '.', ',');

                    $sumasXProyecto[$id] = array(
                        'sumaTons' => $sumaTons,
                        'sumaDuro' => $sumaDuro,
                        'sumaSuave' => $sumaSuave,
                        'nombre' => $nombre,
                        'sumando' => $sumando,
                        'id' => $ids
                    );
                    $nombre = $fila['nombre_proyecto'];
                    $ids = "diferente" . $fila['id'];
                    $id = $fila['id'];
                    $sumando = $fila['tons_co2'];
                    $sumaTons = (float)$fila['tons_co2'];
                    $sumaDuro = (float)str_replace(['$', ','], '', $fila['ahorro_duro']);
                    $sumaSuave = (float)str_replace(['$', ','], '', $fila['ahorro_suave']);
                    $valor1 = 0.0;
                    $valor2  = 0.0;
                    $valor3  = 0.0;
                    $doce_vueltas++;
                } else {
                    if ($doce_vueltas <= 12) {
                        $valor1 = (float)$fila['tons_co2'];
                        $sumaTons += $valor1;
                        // Eliminar el sigono de "$" y las comas y convertir a float
                        $valor2 = (float)str_replace(['$', ','], '', $fila['ahorro_duro']);
                        $sumaDuro += $valor2;
                        $valor3 = (float)str_replace(['$', ','], '', $fila['ahorro_suave']);
                        $sumaSuave += $valor3;
                        $sumando .= " " . $fila['tons_co2'];
                        $ids .= " " . $fila['id'];
                        $doce_vueltas++;
                    }
                    if ($ultimaFila === $todaslasvueltas) { //cuando ya no es diferente pero se realiza la ultima vuelta guardo toda la suma
                        $sumaTons = number_format($sumaTons, 2, '.', ',');
                        $sumaDuro = "$" . number_format($sumaDuro, 2, '.', ',');
                        $sumaSuave = "$" . number_format($sumaSuave, 2, '.', ',');

                        $sumasXProyecto[$id] = array(
                            'sumaTons' => $sumaTons,
                            'sumaDuro' => $sumaDuro,
                            'sumaSuave' => $sumaSuave,
                            'nombre' => $nombre,
                            'sumando' => $sumando,
                            'id' => $ids
                        );
                    }
                }
            }
        }
    } else {
        $estado2 = $conexion->error;
    }

    return array($resultado, $estado, $sumasXProyecto, $estado2, $checando);
}

function consultarProyectosID($id_proyecto)
{
    global $conexion;
    $resultado = [];
    $estado = false;
    $consulta = "SELECT * FROM proyectos_creados WHERE id ='$id_proyecto'";
    $query = $conexion->query($consulta);
    if ($query) {
        while ($datos = mysqli_fetch_array($query)) {
            $resultado[] = $datos;
        }
        $estado = true;
    } else {
        $estado = false;
    }
    return array($resultado, $estado);
}

function insertarProyecto($folio, $fecha_alta, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id, $misiones, $pilares, $objetivos, $impacto_ambiental, $tons_co2, $ahorro_duro, $ahorro_suave)
{
    global $conexion;
    $folio_sin_numero = "";
    $folio_recuperado = "";
    $igual = "";
    $numero = 1;
    $ultimoNum = "";
    $select = "SELECT folio FROM proyectos_creados WHERE folio LIKE '$folio%' ORDER BY id DESC LIMIT 1";
    $query = $conexion->query($select);
    if ($query) {
        $estado_folios = true;
        if ($query->num_rows > 0) {
            $fila = $query->fetch_assoc();
            $folio_recuperado = $fila['folio'];
            $partes = explode("#", $folio_recuperado);
            $folio_sin_numero = rtrim($partes[0], "-");

            if ($folio == $folio_sin_numero) { //comparo el folio recuperado
                $ultimoNum = end($partes);
                $numero = intval($ultimoNum) + 1;
                $igual = "Si";
            } else {
                $igual = "No";
            }
        }
    } else {
        $estado_folios = false;
    }

    $nuevo_folio = $folio . "-#" . $numero; //agrego el numero que sigue al folio
    $consulta = "SELECT * FROM responsables WHERE id = $responsable_id";
    $query = $conexion->query($consulta);
    if ($query->num_rows > 0) {
        //Recuperado el responsable inserto
        $fila = $query->fetch_assoc();
        $nombre_responsable = $fila['nombre'];
        $correo_responsable =  $fila['correo'];
        $telefono_responsable =  $fila['telefono'];

        $separando = explode("-", $fecha_alta);
        $fecha_invertida = $separando[2] . "-" . $separando[1] . "-" . $separando[0];
        $estado  = true;
        //Inserto el proyecto
        $query = "INSERT INTO proyectos_creados (folio,fecha, fuente, nombre_proyecto, planta, area, departamento, metodologia, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental, tons_co2, ahorro_duro, ahorro_suave) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssssssssssssss", $nuevo_folio, $fecha_invertida, $fuente, $nombre_proyecto, $planta, $area, $departamento, $metodologia, $nombre_responsable, $correo_responsable, $telefono_responsable, $misiones, $pilares, $objetivos, $impacto_ambiental, $tons_co2, $ahorro_duro, $ahorro_suave);
        if ($stmt->execute()) {
            $estado = true;
            //insertado el proyecto, ahora inserto los impactos ambientales en otra tabla
            $insercion_impacto = "Correcto";
            $ultimo_id = $conexion->insert_id;
            $impacto_ambiental_array = json_decode($impacto_ambiental, JSON_UNESCAPED_UNICODE);
            foreach ($impacto_ambiental_array as $impacto) {
                $consulta = "INSERT INTO impacto_ambiental_proyecto (id_proyecto,impacto_ambiental) VALUES ('$ultimo_id','$impacto')";
                if ($conexion->query($consulta) !== TRUE) {
                    $insercion_impacto = "Incorreco";
                    break;
                }
            }
        }
        $stmt->close();
    } else {
        $estado  = false;
    }

    return array($estado, $estado_folios, $folio_recuperado, $folio_sin_numero, $igual, $insercion_impacto, $impacto_ambiental_array);
}


function actualizarStatusCerradoSiguiendo($id_proyecto, $status)
{
    global $conexion;
    $estado = false;
    $update = "UPDATE proyectos_creados SET status_seguimiento=? WHERE  id=?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("si", $status, $id_proyecto);
    if ($stmt->execute()) {
        $estado = true;
    }
    $stmt->close();
    return $estado;
}


function eliminarProyecto($id)
{
    global $conexion;
    $estado = false;
    $delete = "DELETE FROM proyectos_creados WHERE id=?";
    $stmt = $conexion->prepare($delete);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $estado = true;
    }

    $stmt->close();
    return $estado;
}
