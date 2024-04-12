<?php
$nomina = $_SESSION['nomina'];
include("conexionGhoner.php");
function consultarProyectos()
{
    global $nomina;
    global $conexion;
    $resultado = [];
    $estado = false;
    if ($_SESSION['acceso'] == "Admin" || $_SESSION['acceso'] == "Financiero") {
        $consulta = "SELECT * FROM proyectos_creados ORDER BY folio ASC";
    } else {
        $consulta = "SELECT * FROM proyectos_creados WHERE nomina='$nomina' OR observador LIKE '%$nomina%' ORDER BY folio ASC";
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

function sumaValoresGonher(){
    global $conexion;
    $estado = false;

    $valores = [];
    $sumaCalidad =0; $sumaTrabajo =0; $sumaCompromiso =0; $sumaServicio =0;  $sumaDesarrollo =0; $sumaIntegridad =0; $sumaInnovacion=0;

    $consulta = "SELECT * FROM proyectos_creados";
    if($query = $conexion->query($consulta)){
        $estado = true;
    }
    while($fila = $query->fetch_array()) {
        $valor = $fila['valores'];
        //contando valores 
        $cantidad1=substr_count($valor,"Calidad - Productividad");
        $cantidad2=substr_count($valor,"Trabajo en Equipo");
        $cantidad3=substr_count($valor,"Compromiso");
        $cantidad4=substr_count($valor,"Servicio y Orientación al Cliente");
        $cantidad5=substr_count($valor,"Desarrollo de Nuestra Gente");
        $cantidad6=substr_count($valor,"Integridad");
        $cantidad7=substr_count($valor,"Innovación");

        $sumaCalidad += $cantidad1;  
        $sumaTrabajo += $cantidad2; 
        $sumaCompromiso += $cantidad3;
        $sumaServicio += $cantidad4; 
        $sumaDesarrollo += $cantidad5; 
        $sumaIntegridad += $cantidad6; 
        $sumaInnovacion += $cantidad7; 
    }

    $valores['Calidad'] = $sumaCalidad;
    $valores['Trabajo'] = $sumaTrabajo;
    $valores['Compromiso'] = $sumaCompromiso;
    $valores['Servicio'] = $sumaServicio;
    $valores['Desarrollo'] = $sumaDesarrollo;
    $valores['Integridad'] = $sumaIntegridad;
    $valores['Innovacion'] = $sumaInnovacion;


    return array($valores,$estado);
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

function consultarCalendarioProyecto($anio)
{
    global $conexion;
    $resultado1 = [];
    $sumasPorMes['sumas_ahorro_duro'] = [];
    $sumasPorMes['sumas_ahorro_suave'] = [];
    $estado1 = false;
    $suma = 0;
    $consulta = "SELECT DISTINCT proyectos_creados.id AS proyectoID, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.mes, registros_impacto_ambiental.anio, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.ahorro_suave, registros_impacto_ambiental.validado, proyectos_creados.id /*Datos Proyecto */
    FROM impacto_ambiental_proyecto JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id 
    JOIN registros_impacto_ambiental ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE registros_impacto_ambiental.anio ='$anio'";
    $query = $conexion->query($consulta);
    if ($query) {
        while ($datos = mysqli_fetch_array($query)) {
            $ahorro_duro = str_replace(['$',','],'', $datos['ahorro_duro']);//eliminando caracteres
            $ahorro_duro= floatval($ahorro_duro);//conviertiendolo a número
            $ahorro_suave = str_replace(['$',','],'', $datos['ahorro_suave']);//eliminando caracteres
            $ahorro_suave = floatval($ahorro_suave);//a flotante

            if(!isset($sumasPorMes['sumas_ahorro_duro'][$datos['mes']])){
                $sumasPorMes['sumas_ahorro_duro'][$datos['mes']]=0;
            }

            if(!isset($sumasPorMes['sumas_ahorro_suave'][$datos['mes']])){
                $sumasPorMes['sumas_ahorro_suave'][$datos['mes']]=0;
            }

            $sumasPorMes['sumas_ahorro_suave'][$datos['mes']]+=$ahorro_suave;
            $sumasPorMes['sumas_ahorro_duro'][$datos['mes']]+=$ahorro_duro;
            $resultado1[] = $datos;
        }
        //dandole formato a las posiciones
        foreach ($sumasPorMes['sumas_ahorro_duro'] as $elmes => $suma) {
            $sumasPorMes['sumas_ahorro_duro'][$elmes] = "$".number_format($suma,2,".",","); 
        }

        foreach ($sumasPorMes['sumas_ahorro_suave'] as $elmes => $suma){
            $sumasPorMes['sumas_ahorro_suave'][$elmes] = "$".number_format($suma,2,".",",");
        }

        $estado1 = true;
    } else {
        $estado1 = false;
    }

    $resultado2 =[];
    $estado2 = false;
    $anioActual=intval($anio);
    $anioAnterior = $anioActual-1;
    $consulta="SELECT proyectos_creados.responsable,proyectos_creados.correo,proyectos_creados.telefono,proyectos_creados.nombre_proyecto,proyectos_creados.id,proyectos_creados.fecha, proyectos_creados.objetivos, registros_impacto_ambiental.mes,proyectos_creados.status_seguimiento /*Proyectos por año Unicos listado de proyectos a mostrar*/
    FROM impacto_ambiental_proyecto LEFT JOIN proyectos_creados 
    ON proyectos_creados.id = impacto_ambiental_proyecto.id_proyecto 
    LEFT JOIN registros_impacto_ambiental 
    ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto 
    WHERE registros_impacto_ambiental.anio = '$anio' 
    OR (registros_impacto_ambiental.anio = '$anioAnterior' AND proyectos_creados.status_seguimiento!='Cerrado') 
    OR (RIGHT(proyectos_creados.fecha, 4) = '$anio')
     GROUP BY impacto_ambiental_proyecto.id_proyecto"; //le agrege el right para mostrar tambien aquellos que concidan con los ultimos 4 (anio) valores del string en campo fecha
    $query = $conexion->query($consulta);
    if($query){
        $estado2 = true;
        while ($nombres_proyectos = mysqli_fetch_array($query)) {

            $objetivos_array = json_decode($nombres_proyectos['objetivos'], true);

            foreach ($objetivos_array as $elemento) {
               if (strpos($elemento,'->directo')!==false){
                    $nombres_proyectos['directo'] = $elemento; // inserto solo si existe el string
               }
            }
            $resultado2[] = $nombres_proyectos;
        }
    }else{
        $estado2 = false;
    }

    $resultado3 =[];
    $estado3 = false;
    $consulta = "SELECT DISTINCT proyectos_creados.id AS proyectoID, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.mes, registros_impacto_ambiental.anio, proyectos_creados.id /*Contando Meses*/
    FROM impacto_ambiental_proyecto JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id 
    JOIN registros_impacto_ambiental ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto";
    $query = $conexion->query($consulta);
    if($query){
        $estado3 = true;
        while ($todos_los_proyectos = mysqli_fetch_array($query)) {
           // Contar ocurrencias de proyectos_creados.id
        $id_proyecto = $todos_los_proyectos['proyectoID'];
        if (isset($proyectos_repetidos[$id_proyecto])) {
            $proyectos_repetidos[$id_proyecto]++;
        } else {
            $proyectos_repetidos[$id_proyecto] = 1;
        }
    }
     // Agregar la cantidad de ocurrencias al resultado
     foreach ($proyectos_repetidos as $id_proyecto => $ocurrencias) {
        $resultado3[$id_proyecto] = $ocurrencias;
    }
    


    }else{
        $estado3 = false;
    }

    return array($resultado1, $estado1,$resultado2,$estado2,$resultado3,$estado3,$sumasPorMes);
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

function insertarProyecto($folio, $fecha_alta, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, $objetivos, $impacto_ambiental, $valores, $tons_co2, $ahorro_duro, $ahorro_suave)
{
    global $conexion;
    $folio_sin_numero = "";
    $folio_recuperado = "";
    $igual = "";
    $numero = 1;
    $ultimoNum = "";
    if($observador=='[""]'){
        $observador = "";
    }
    $select = "SELECT folio FROM proyectos_creados WHERE folio LIKE '$folio%' ORDER BY id DESC LIMIT 1";//Consulta para buscar si existe un folio simiar y sumarle 1;
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
        $query = "INSERT INTO proyectos_creados (folio,fecha, fuente, nombre_proyecto, planta, area, departamento, metodologia,nomina, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental,valores, tons_co2, ahorro_duro, ahorro_suave,observador) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssssssssssssssss", $nuevo_folio, $fecha_invertida, $fuente, $nombre_proyecto, $planta, $area, $departamento, $metodologia, $nomina, $nombre_responsable, $correo_responsable, $telefono_responsable, $misiones, $pilares, $objetivos, $impacto_ambiental,$valores, $tons_co2, $ahorro_duro, $ahorro_suave,$observador);
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

function actualizarProyecto($id,$valores){
    global $conexion;
    $estado = false;
    $update = "UPDATE proyectos_creados SET valores=? WHERE  id=?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("si", $valores, $id);
    if ($stmt->execute()) {
        $estado = true;
    }
    $stmt->close();
    return $estado;
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
