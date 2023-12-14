<?php
$nomina = $_SESSION['nomina'];
include("conexionGhoner.php");
function consultarProyectos()
{
    global $nomina;
    global $conexion;
    $resultado = [];
    $estado = false;
    if ($_SESSION['acceso'] == "Admin") {
        $consulta = "SELECT * FROM proyectos_creados ORDER BY folio ASC";
    } else {
        $consulta = "SELECT * FROM proyectos_creados WHERE nomina='$nomina' ORDER BY folio ASC";
    }

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
}

function consultarSumaProyecto()
{
    global $conexion;
    $estado1 = false;
    $estado2 = false;
    $id = null;
    $nombre = "";
    $sumasXProyecto = array();
    $id_impacto_ambiental = null;
    $query = "SELECT proyectos_creados.nombre_proyecto, impacto_ambiental_proyecto.id_proyecto,impacto_ambiental_proyecto.id FROM impacto_ambiental_proyecto JOIN proyectos_creados ON proyectos_creados.id = impacto_ambiental_proyecto.id_proyecto GROUP BY impacto_ambiental_proyecto.id_proyecto"; //AGRUPO LOS PROYECTO EXISTENTES
    if ($datos = $conexion->query($query)) {
        $estado1 = true;
        if ($datos->num_rows > 0) {
            while ($fila = $datos->fetch_assoc()) { //estoy tomando solo un id de impacto ambietal para sumar ya que tomo todos se duplicar o triplicara el valor, esto por la cantidad de columnas de impacto ambiental
                $id = $fila['id_proyecto'];
                /*$idUnicosImpacto[$id] = array();
                $idUnicosImpacto[$id] = $fila['id']; //id del impacto ambiental*/
                $sumasXProyecto[$id] = array();
                $id_impacto_ambiental = $fila['id']; //id del impacto ambiental
                $nombre = $fila['nombre_proyecto'];
                $sumaTons = 0;
                $sumaDuro = 0;
                $sumaSuave = 0;
                $valor1 = 0;
                $valor2  = 0;
                $valor3  = 0;
                $consulta = "SELECT impacto_ambiental_proyecto.id_proyecto, registros_impacto_ambiental.id_impacto_ambiental_proyecto, registros_impacto_ambiental.tons_co2,registros_impacto_ambiental.ahorro_suave, registros_impacto_ambiental.ahorro_duro   
                FROM impacto_ambiental_proyecto JOIN registros_impacto_ambiental  ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE  registros_impacto_ambiental.id_impacto_ambiental_proyecto = '$id_impacto_ambiental'";
                if ($resultado = $conexion->query($consulta)) {
                    $estado2 = true;
                    if ($resultado->num_rows > 0) {
                        while ($dat = $resultado->fetch_array()) {
                            $valor1 = (float)$dat['tons_co2'];
                            $sumaTons += $valor1;
                            $valor2 = (float)str_replace(['$', ','], '', $dat['ahorro_duro']);
                            $sumaDuro += $valor2;
                            $valor3 = (float)str_replace(['$', ','], '', $dat['ahorro_suave']);
                            $sumaSuave += $valor3;
                        }
                        $sumaTons = number_format($sumaTons, 2, '.', ',');
                        $sumaDuro = "$" . number_format($sumaDuro, 2, '.', ',');
                        $sumaSuave = "$" . number_format($sumaSuave, 2, '.', ',');
                        $sumasXProyecto[$id] = array(
                            'sumaTons' => $sumaTons,
                            'sumaDuro' => $sumaDuro,
                            'sumaSuave' => $sumaSuave,
                            'nombre' => $nombre,
                        );
                    }
                } else {
                    $estado2 = $conexion->error;
                }
            }
        } else {
            $estado2 = true; // si no hay nada en consulta 1 lo pongo true por que no entrara
        }
    } else {
        $estado1 = $conexion->error;
    }

    return array($sumasXProyecto, $estado1, $estado2);
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
        $nomina = $fila['numero_nomina'];
        $nombre_responsable = $fila['nombre'];
        $correo_responsable =  $fila['correo'];
        $telefono_responsable =  $fila['telefono'];

        $separando = explode("-", $fecha_alta);
        $fecha_invertida = $separando[2] . "-" . $separando[1] . "-" . $separando[0];
        $estado  = true;
        //Inserto el proyecto
        $query = "INSERT INTO proyectos_creados (folio,fecha, fuente, nombre_proyecto, planta, area, departamento, metodologia,nomina, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental, tons_co2, ahorro_duro, ahorro_suave) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssssssssssssss", $nuevo_folio, $fecha_invertida, $fuente, $nombre_proyecto, $planta, $area, $departamento, $metodologia, $nomina, $nombre_responsable, $correo_responsable, $telefono_responsable, $misiones, $pilares, $objetivos, $impacto_ambiental, $tons_co2, $ahorro_duro, $ahorro_suave);
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
