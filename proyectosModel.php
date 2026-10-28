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
function consultarProyectosPorAnioSelected($anio){
    global $conexion;
    $resultado1 = [];
    $sumasPorMes['sumas_ahorro_duro'] = [];
    $sumasPorMes['sumas_ahorro_suave'] = [];
    $estado = false;
    $suma = 0;
    $consulta = "SELECT DISTINCT proyectos_creados.id AS proyectoID, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.mes, registros_impacto_ambiental.tons_co2, registros_impacto_ambiental.anio, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.ahorro_suave, registros_impacto_ambiental.status_rechazo, registros_impacto_ambiental.motivo_rechazo, registros_impacto_ambiental.validado, proyectos_creados.id /*Datos Proyecto */
    FROM impacto_ambiental_proyecto JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id 
    JOIN registros_impacto_ambiental ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE registros_impacto_ambiental.anio ='$anio'";
    $query = $conexion->query($consulta);
    if ($query) {
        $sumaTotalAhorroDuro = 0;
        while ($datos = mysqli_fetch_array($query)) {
            $ahorro_duro = str_replace(['$',','],'', $datos['ahorro_duro']);//eliminando caracteres
            $ahorro_duro= floatval($ahorro_duro);//conviertiendolo a número
            $sumaTotalAhorroDuro += $ahorro_duro;
            if(!isset($sumasPorMes['sumas_ahorro_duro'][$datos['mes']])){
                $sumasPorMes['sumas_ahorro_duro'][$datos['mes']]=0;
            }
            $sumasPorMes['sumas_ahorro_duro'][$datos['mes']]+=$ahorro_duro;
            $resultado1[] = $datos;
        }
        //dandole formato a las posiciones
        foreach ($sumasPorMes['sumas_ahorro_duro'] as $elmes => $suma) {
            $sumasPorMes['sumas_ahorro_duro'][$elmes] = "$".number_format($suma,2,".",","); 
        }
        $sumasPorMes['global_anual_ahorro_duro'] = "$" . number_format($sumaTotalAhorroDuro, 2, ".", ",");
        
        $estado = true;
    } else {
        $estado = false;
    }
    return array($resultado1, $estado, $sumasPorMes);
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
        $cantidad1=substr_count($valor,"Excelencia");
        $cantidad2=substr_count($valor,"Colaboración");
        $cantidad3=substr_count($valor,"Compromiso");
        $cantidad4=substr_count($valor,"Servicio");
        $cantidad5=substr_count($valor,"Desarrollo");
        $cantidad6=substr_count($valor,"Integridad");
        $cantidad7=substr_count($valor,"Innovación");

        /*$cantidad1=substr_count($valor,"Calidad - Productividad");
        $cantidad2=substr_count($valor,"Trabajo en Equipo");
        $cantidad3=substr_count($valor,"Compromiso");
        $cantidad4=substr_count($valor,"Servicio y Orientación al Cliente");
        $cantidad5=substr_count($valor,"Desarrollo de Nuestra Gente");
        $cantidad6=substr_count($valor,"Integridad");
        $cantidad7=substr_count($valor,"Innovación");*/

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

function consultarCalendarioProyecto($anio,$planta)
{
    global $conexion;
    $resultado1 = [];
    $sumasPorMes['sumas_ahorro_duro'] = [];
    $sumasPorMes['sumas_ahorro_suave'] = [];
    $estado1 = false;
    $suma = 0;
    $consulta = "SELECT DISTINCT proyectos_creados.id AS proyectoID, proyectos_creados.nombre_proyecto, registros_impacto_ambiental.mes, registros_impacto_ambiental.tons_co2, registros_impacto_ambiental.anio, registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.ahorro_suave, registros_impacto_ambiental.status_rechazo, registros_impacto_ambiental.motivo_rechazo, registros_impacto_ambiental.validado, proyectos_creados.id /*Datos Proyecto */
    FROM impacto_ambiental_proyecto JOIN proyectos_creados ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id 
    JOIN registros_impacto_ambiental ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE registros_impacto_ambiental.anio ='$anio' AND  proyectos_creados.planta LIKE '%$planta%'";
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
    $consulta="SELECT proyectos_creados.responsable,proyectos_creados.planta,proyectos_creados.correo,proyectos_creados.telefono,proyectos_creados.nombre_proyecto,proyectos_creados.id,proyectos_creados.fecha, proyectos_creados.objetivos, proyectos_creados.presupuestado, registros_impacto_ambiental.mes,proyectos_creados.status_seguimiento /*Proyectos por año Unicos listado de proyectos a mostrar*/
    FROM impacto_ambiental_proyecto LEFT JOIN proyectos_creados 
    ON proyectos_creados.id = impacto_ambiental_proyecto.id_proyecto 
    LEFT JOIN registros_impacto_ambiental 
    ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto 
   WHERE (
        registros_impacto_ambiental.anio = '$anio' AND proyectos_creados.planta LIKE '%$planta%'
    ) OR (
        registros_impacto_ambiental.anio = '$anioAnterior' AND proyectos_creados.status_seguimiento != 'Cerrado' AND proyectos_creados.planta LIKE '%$planta%'
    ) OR (
        RIGHT(proyectos_creados.fecha, 4) = '$anio' AND proyectos_creados.planta LIKE '%$planta%'
    )
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
    $fuente = "";
    $planta = "";
    $area = "";
    $responsable = "";
    $estado = false;
    $soloSiglas="";
    $responsablesArreglo = [];
    $consulta = "SELECT * FROM proyectos_creados WHERE id ='$id_proyecto'";
    $query = $conexion->query($consulta);
    if ($query) {
        while ($datos = mysqli_fetch_array($query)) {
            $resultado[] = $datos;
            $fuenteBuscar = $datos['fuente'];
            $plantaBuscar = $datos['planta'];
            $areaBuscar = $datos['area'];
            $departamentoBuscar = $datos['departamento'];
            $metodologiaBuscar = $datos['metodologia'];
            $responsableBuscar = $datos['responsable'];
            $observadorBuscar = $datos['observador'];
            //necesito declarar o agregar las variables de la consulta dnetro del for en agunlugar por aqui?
        }
        $estado = true;
    } else {
        $estado = false;
    }
   
    if(preg_match('/\(([^)]+)\)/', $fuenteBuscar, $matches)){
        $soloSiglas = $matches[1];

        $consulta2 = "SELECT * FROM fuentes WHERE siglas ='$soloSiglas'";
        $query2 = $conexion->query($consulta2);
        if ($query2) {
        while ($datos2 = mysqli_fetch_array($query2)) {
            $fuente = $datos2;
        }
        $estado = true;
        } else {
        $estado = false;
        }
    }else{
        $soloSiglas = "No se encontró ninguna sigla";
    }



        $consulta3 = "SELECT * FROM plantas WHERE nombre ='$plantaBuscar'";
        $query3 = $conexion->query($consulta3);
        if ($query3) {
        while ($datos3 = mysqli_fetch_array($query3)) {
            $planta = $datos3;
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $consulta4 = "SELECT * FROM areas WHERE nombre ='$areaBuscar'";
        $query4 = $conexion->query($consulta4);
        if ($query4) {
        while ($datos4 = mysqli_fetch_array($query4)) {
            $area = $datos4;
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $consulta5 = "SELECT * FROM departamentos WHERE nombre ='$departamentoBuscar'";
        $query5 = $conexion->query($consulta5);
        if ($query5) {
        while ($datos5 = mysqli_fetch_array($query5)) {
            $departamento = $datos5;
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $consulta6 = "SELECT * FROM metodologias WHERE nombre ='$metodologiaBuscar'";
        $query6 = $conexion->query($consulta6);
        if ($query6) {
        while ($datos6 = mysqli_fetch_array($query6)) {
            $metodologia = $datos6;
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $consulta7 = "SELECT * FROM responsables WHERE nombre ='$responsableBuscar'";
        $query7 = $conexion->query($consulta7);
        if ($query7) {
        while ($datos7 = mysqli_fetch_array($query7)) {
            $responsable = $datos7;
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $consulta8 = "SELECT observador FROM proyectos_creados WHERE observador ='$observadorBuscar'";
        $query8 = $conexion->query($consulta8);
        if ($query8) {
        while ($datos8 = mysqli_fetch_array($query8)) {
            $observador = $datos8;
            $textoObservador = $datos8['observador']; // Solo la columna observador
        }
        $estado = true;
        } else {
        $estado = false;
        }

        $arregloObservador = json_decode($textoObservador, true); // Convertimos el JSON a arreglo PHP
        $cantidad = count($arregloObservador);

        for($i=0; $i<$cantidad; $i++){
            $nomina=$arregloObservador[$i];
            $consulta9 = "SELECT * FROM responsables WHERE numero_nomina ='$nomina'";
            $query9 = $conexion->query($consulta9);
            if ($query9) {
                 while ($datos9 = mysqli_fetch_array($query9)) {
                    $responsablesArreglo[] = $datos9;
                }
                $estado = true;
            } else {
                $estado = false;
            }
        }



        /*$consulta8 = "SELECT nombre, numero_nomina FROM responsables WHERE nombre ='$observadorBuscar'";
        $query8 = $conexion->query($consulta8);
        if ($query8) {
        while ($datos8 = mysqli_fetch_array($query8)) {
            $observador[] = [
                'nombre' => $datos8['nombre'],
                'numero_nomina' => $datos8['numero_nomina'] 
            ];
        }
        $estado = true;
        } else {
        $estado = false;
        }*/
    
   
    /*$fuenteBuscar //rescar lo que este dentro de los parentesis seran las SIGLAS
    //$aquiSiglas //nueva varibale con las siglas

    //bucar en la BD siglas que sean iguales WHERE id ='$id_proyecto'*/
   
    

    return array($resultado, $estado,$fuenteBuscar, $soloSiglas, $fuente, $plantaBuscar, $planta, $areaBuscar, $area, $departamentoBuscar, $departamento, $metodologiaBuscar, $metodologia, $responsableBuscar, $responsable,
     $observadorBuscar, $observador, $arregloObservador, $cantidad, $responsablesArreglo);
}

function insertarProyecto($folio, $fecha_alta_invertida, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, $tons_co2, $ahorro_duro, $ahorro_suave, $anioXmes, $mesXAnio, $valoresMensualCO, $valoresMensualAD, $valoresMensualAS, $presupuestado, $mesesPresupuestados, $diagrama_proceso, $tipo, $cantidad, $referencia, $id_eads,$impactos_completos)
{
    global $conexion;
    $folio_sin_numero = "";
    $folio_recuperado = "";
    $igual = "";
    $numero = 1;
    $ultimoNum = "";
    $impacto_mensual = "";

    $select = "SELECT folio FROM proyectos_creados WHERE folio LIKE '$folio%' ORDER BY id DESC LIMIT 1";
    $query = $conexion->query($select);
    if ($query) {
        $estado_folios = true;
        if ($query->num_rows > 0) {
            $fila = $query->fetch_assoc();
            $folio_recuperado = $fila['folio'];
            $partes = explode("#", $folio_recuperado);
            $folio_sin_numero = rtrim($partes[0], "-");

            if ($folio == $folio_sin_numero) {
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

    $nuevo_folio = $folio . "-#" . $numero; 
    
    $consulta = "SELECT * FROM responsables WHERE id = '$responsable_id'";
    $query = $conexion->query($consulta);
    if ($query && $query->num_rows > 0) {
        $fila = $query->fetch_assoc();
        $nomina = $fila['numero_nomina'];
        $nombre_responsable = $fila['nombre'];
        $correo_responsable =  $fila['correo'];
        $telefono_responsable =  $fila['telefono'];

        $estado = true;

        if (is_string($impactos_completos)) {
            $dec = json_decode($impactos_completos, true);
            if (is_string($dec)) { $dec = json_decode($dec, true); } 
            $impactos_completos = is_array($dec) ? $dec : [];
        }
        if (!is_array($impactos_completos)) {
            $impactos_completos = [];
        }

        if (!empty($impactos_completos)) {
            foreach ($impactos_completos as $imp) {
                if (empty($imp['concepto']) || $imp['concepto'] === 'Sin Impacto') continue;

                $concepto = $conexion->real_escape_string(trim($imp['concepto']));
                $um = $conexion->real_escape_string(trim($imp['um'] ?? ''));
                $ref = $conexion->real_escape_string(trim($imp['referencia'] ?? ''));

                $check = $conexion->query("SELECT id FROM impacto_ambiental WHERE nombre = '$concepto'");
                if ($check && $check->num_rows == 0) {
                    $conexion->query("INSERT INTO impacto_ambiental (nombre, unidad, requisito) VALUES ('$concepto', '$um', '$ref')");
                }
            }
        }

        $queryIns = "INSERT INTO proyectos_creados (folio, fecha, fuente, nombre_proyecto, planta, area, departamento, metodologia, nomina, responsable, correo, telefono, misiones, pilares, objetivos, impacto_ambiental, alcance, valores, tons_co2, ahorro_duro, ahorro_suave, observador, presupuestado, diagrama_proceso, tipo, cantidad, referencia, id_eads) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conexion->prepare($queryIns);
        $stmt->bind_param("ssssssssssssssssssssssssssss", 
            $nuevo_folio, $fecha_alta_invertida, $fuente, $nombre_proyecto, $planta, $area, $departamento, $metodologia, $nomina, $nombre_responsable, $correo_responsable, $telefono_responsable, $misiones, $pilares, $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, $tons_co2, $ahorro_duro, $ahorro_suave, $observador, $presupuestado, $diagrama_proceso, $tipo, $cantidad, $referencia, $id_eads
        );

        if ($stmt->execute()) {
            $estado = true;
            $ultimo_id = $conexion->insert_id;

            $conexionOPEX = $conexion;

            include("conexionEAD.php");
            $conexionEAD = $conexion;

            $conexion = $conexionOPEX;

            if (isset($conexionEAD) && !$conexionEAD->connect_errno) {
                $conexionEAD->set_charset("utf8");

                $id_equipo_ead = null;
                $nombre_indicador_ead = $nombre_proyecto;

                foreach ($impactos_completos as $imp) {
                    $id_ead_row = $imp["id_eads"] ?? $imp["Id_eads"] ?? null;
                    if (!empty($id_ead_row)) {
                        $stmtFind = $conexionEAD->prepare("SELECT id_equipo, nombre_indicador FROM reportes_impactos_ambientales_proyectos WHERE id = ? LIMIT 1");

                        if ($stmtFind) {
                            $stmtFind->bind_param("i", $id_ead_row);
                            $stmtFind->execute();
                            $res = $stmtFind->get_result();
                            if ($row = $res->fetch_assoc()) {
                                $id_equipo_ead = $row["id_equipo"];
                                $nombre_indicador_ead = $row["nombre_indicador"];
                            }
                            $stmtFind->close();
                        }
                        break;
                    }
                }

                $nuevos_ids_eads = [];
                $hubo_inserciones = false;

                $stmtUpdateEAD = $conexionEAD->prepare("UPDATE reportes_impactos_ambientales_proyectos SET diagrama=?, tipo=?, concepto=?, alcance=?, cantidad=?, um=?, co2=?, referencia=? WHERE id=?");

                $stmtUpdateEAD = null;
                if (!empty($id_equipo_ead)) {
                    $stmtInsertEAD = $conexionEAD->prepare("INSERT INTO reportes_impactos_ambientales_proyectos (id_equipo, nombre_indicador, diagrama, tipo, concepto, alcance, cantidad, um, co2, referencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                }

                foreach ($impactos_completos as $imp) {
                    $diagrama_ead = $imp["diagrama"] ?? "";
                    $tipo_ead     = $imp["tipo"] ?? "";
                    $concepto_ead = $imp["concepto"] ?? "";
                    $alcance_ead  = $imp["alcance"] ?? "";
                    $cantidad_ead = (float)($imp["cantidad"] ?? 0);
                    $um_ead       = $imp["um"] ?? "";
                    $co2_ead      = (float)($imp["co2"] ?? 0);
                    $ref_ead      = $imp["referencia"] ?? "";

                    $id_ead_row = $imp["id_eads"] ?? $imp["Id_eads"] ?? null;

                    if (!empty($id_ead_row)) {
                        if ($stmtUpdateEAD) {
                            $stmtUpdateEAD->bind_param("ssssdsdsi", $diagrama_ead, $tipo_ead, $concepto_ead, $alcance_ead, $cantidad_ead, $um_ead, $co2_ead, $ref_ead, $id_ead_row);
                            $stmtUpdateEAD->execute();
                        }
                        $nuevos_ids_eads[] = $id_ead_row;
                    } else {
                        if (!empty($id_equipo_ead) && $stmtInsertEAD) {
                            $stmtInsertEAD->bind_param("ssssssdsds", $id_equipo_ead, $nombre_indicador_ead, $diagrama_ead, $tipo_ead, $concepto_ead, $alcance_ead, $cantidad_ead, $um_ead, $co2_ead, $ref_ead);
                            $stmtInsertEAD->execute();

                            $nuevo_id = $conexionEAD->insert_id;
                            $nuevos_ids_eads[] = $nuevo_id;
                            $hubo_inserciones = true;
                        } else {
                            $nuevos_ids_eads[] = null;
                        }
                    }
                }

                if ($stmtUpdateEAD) $stmtUpdateEAD->close();
                if ($stmtInsertEAD) $stmtInsertEAD->close();
                $conexionEAD->close();

                if ($hubo_inserciones) {
                    $json_ids_actualizado = json_encode($nuevos_ids_eads, JSON_UNESCAPED_UNICODE);
                    $stmtUpdateOpex = $conexion->prepare("UPDATE proyectos_creados SET id_eads = ? WHERE id = ?");

                    if ($stmtUpdateOpex) {
                        $stmtUpdateOpex->bind_param("si", $json_ids_actualizado, $ultimo_id);
                        $stmtUpdateOpex->execute();
                        $stmtUpdateOpex->close();
                    }
                }
            }
            
            $anioXmes = !is_array($anioXmes) ? json_decode($anioXmes, true) : $anioXmes;
            $mesXAnio = !is_array($mesXAnio) ? json_decode($mesXAnio, true) : $mesXAnio;
            $valoresMensualCO = !is_array($valoresMensualCO) ? json_decode($valoresMensualCO, true) : $valoresMensualCO;
            $valoresMensualAD = !is_array($valoresMensualAD) ? json_decode($valoresMensualAD, true) : $valoresMensualAD;
            $valoresMensualAS = !is_array($valoresMensualAS) ? json_decode($valoresMensualAS, true) : $valoresMensualAS;
            $mesesPresupuestados = !is_array($mesesPresupuestados) ? json_decode($mesesPresupuestados, true) : $mesesPresupuestados;

            $cantidad_meses = is_array($mesXAnio) ? count($mesXAnio) : 0;
            for ($i = 0; $i < $cantidad_meses; $i++) {
                $co = $valoresMensualCO[$i] ?? '';
                $ad = $valoresMensualAD[$i] ?? '';
                $as = $valoresMensualAS[$i] ?? '';
                $mp = $mesesPresupuestados[$i] ?? '';
                $insertarPlan = "INSERT INTO plan_mensual_por_proyecto (id_proyecto, mes, anio, ahorro_co, ahorro_d, ahorro_s, mes_presupuestado) VALUES ('$ultimo_id','$mesXAnio[$i]','$anioXmes[$i]','$co','$ad','$as','$mp')";
                
                if ($conexion->query($insertarPlan) !== TRUE) {
                    $impacto_mensual = $conexion->error . " Incorrecto";
                    break;
                } else {
                    $impacto_mensual = "Correcto";
                }
            }
        }
        $stmt->close();
    } else {
        $estado = false;
    }

    return array($estado, $estado_folios, $folio_recuperado, $folio_sin_numero, $igual, "Correcto", [], $impacto_mensual);
}

function actualizarProyecto($id, $folio, $fecha_alta_invertida, $nombre_proyecto, $selectFuente, $planta, $area, $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, $anioXmes, $mesXAnio, $valoresMensualCO, $valoresMensualAD, $valoresMensualAS, $idsPlanMesual, $presupuestado, $mesesPresupuestados, $diagrama_proceso, $tipo, $cantidad, $referencia, $id_eads, $impactos_completos)
{
    global $conexion;
    $estado = false;

    $nomina = '';
    $nombre_responsable = '';
    $correo_responsable = '';
    $telefono_responsable = '';

    if (!empty($responsable_id)) {
        $consulta = "SELECT * FROM responsables WHERE id = '$responsable_id'";
        $query = $conexion->query($consulta);
        if ($query && $query->num_rows > 0) {
            $fila = $query->fetch_assoc();
            $nomina = $fila['numero_nomina'];
            $nombre_responsable = $fila['nombre'];
            $correo_responsable =  $fila['correo'];
            $telefono_responsable =  $fila['telefono'];
        }
    }

    $folio_final = $folio;
    $consultaFolio = "SELECT folio FROM proyectos_creados WHERE id = '$id'";
    $queryFolio = $conexion->query($consultaFolio);
    if ($queryFolio && $queryFolio->num_rows > 0) {
        $filaF = $queryFolio->fetch_assoc();
        $partesFolio = explode("#", $filaF['folio']);
        if (count($partesFolio) > 1) {
            $ultimoNum = end($partesFolio);
            $folio_final = $folio . "-#" . $ultimoNum;
        }
    }

    if (is_string($impactos_completos)) {
        $dec = json_decode($impactos_completos, true);
        if (is_string($dec)) { $dec = json_decode($dec, true); } 
        $impactos_completos = is_array($dec) ? $dec : [];
    }
    if (!is_array($impactos_completos)) {
        $impactos_completos = [];
    }

    if (!empty($impactos_completos)) {
        foreach ($impactos_completos as $imp) {
            if (empty($imp['concepto']) || $imp['concepto'] === 'Sin Impacto') continue;

            $concepto = $conexion->real_escape_string(trim($imp['concepto']));
            $um = $conexion->real_escape_string(trim($imp['um'] ?? ''));
            $ref = $conexion->real_escape_string(trim($imp['referencia'] ?? ''));

            $check = $conexion->query("SELECT id FROM impacto_ambiental WHERE nombre = '$concepto'");
            if ($check && $check->num_rows == 0) {
                $conexion->query("INSERT INTO impacto_ambiental (nombre, unidad, requisito) VALUES ('$concepto', '$um', '$ref')");
            }
        }
    }

    $update = "UPDATE proyectos_creados SET folio=?, fecha=?, nombre_proyecto=?, fuente=?, planta=?, area=?, departamento=?, metodologia=?, responsable=?, nomina=?, correo=?, telefono=?, observador=?, misiones=?, pilares=?, objetivos=?, impacto_ambiental=?, alcance=?, valores=?, presupuestado=?, diagrama_proceso=?, tipo=?, cantidad=?, referencia=?, id_eads=? WHERE id=?";

    $stmt = $conexion->prepare($update);
    $stmt->bind_param("sssssssssssssssssssssssssi", 
        $folio_final, $fecha_alta_invertida, $nombre_proyecto, $selectFuente, $planta, $area, $departamento, $metodologia, $nombre_responsable, $nomina, $correo_responsable, $telefono_responsable, $observador, $misiones, $pilares, $objetivos, $impacto_ambiental, $impacto_ambiental_emisiones, $valores, $presupuestado, $diagrama_proceso, $tipo, $cantidad, $referencia, $id_eads, $id
    );

    if ($stmt->execute()) {
        $estado = true;
        $conexionOPEX = $conexion; 
        
        include("conexionEAD.php"); 
        $conexionEAD = $conexion;   
        
        $conexion = $conexionOPEX;  
        
        if (isset($conexionEAD) && !$conexionEAD->connect_errno) {
            $conexionEAD->set_charset("utf8");
            
            $id_equipo_ead = null;
            $nombre_indicador_ead = $nombre_proyecto;
            
            foreach ($impactos_completos as $imp) {
                $id_ead_row = $imp['id_eads'] ?? $imp['Id_eads'] ?? null;
                if (!empty($id_ead_row)) {
                    $stmtFind = $conexionEAD->prepare("SELECT id_equipo, nombre_indicador FROM reportes_impactos_ambientales_proyectos WHERE id = ? LIMIT 1");
                    if ($stmtFind) {
                        $stmtFind->bind_param("i", $id_ead_row);
                        $stmtFind->execute();
                        $res = $stmtFind->get_result();
                        if ($row = $res->fetch_assoc()) {
                            $id_equipo_ead = $row['id_equipo'];
                            $nombre_indicador_ead = $row['nombre_indicador'];
                        }
                        $stmtFind->close();
                    }
                    break;
                }
            }
            
            $nuevos_ids_eads = [];
            $hubo_inserciones = false;
            
            $stmtUpdateEAD = $conexionEAD->prepare("UPDATE reportes_impactos_ambientales_proyectos SET diagrama=?, tipo=?, concepto=?, alcance=?, cantidad=?, um=?, co2=?, referencia=? WHERE id=?");
            
            $stmtInsertEAD = null;
            if (!empty($id_equipo_ead)) {
                $stmtInsertEAD = $conexionEAD->prepare("INSERT INTO reportes_impactos_ambientales_proyectos (id_equipo, nombre_indicador, diagrama, tipo, concepto, alcance, cantidad, um, co2, referencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            }
            
            foreach ($impactos_completos as $imp) {
                $diagrama_ead = $imp['diagrama'] ?? '';
                $tipo_ead = $imp['tipo'] ?? '';
                $concepto_ead = $imp['concepto'] ?? '';
                $alcance_ead = $imp['alcance'] ?? '';
                $cantidad_ead = (float)($imp['cantidad'] ?? 0);
                $um_ead = $imp['um'] ?? '';
                $co2_ead = (float)($imp['co2'] ?? 0);
                $ref_ead = $imp['referencia'] ?? '';
                
                $id_ead_row = $imp['id_eads'] ?? $imp['Id_eads'] ?? null;
                
                if (!empty($id_ead_row)) {
                    if ($stmtUpdateEAD) {
                        $stmtUpdateEAD->bind_param("ssssdsdsi", $diagrama_ead, $tipo_ead, $concepto_ead, $alcance_ead, $cantidad_ead, $um_ead, $co2_ead, $ref_ead, $id_ead_row);
                        $stmtUpdateEAD->execute();
                    }
                    $nuevos_ids_eads[] = $id_ead_row;
                } else {
                    if (!empty($id_equipo_ead) && $stmtInsertEAD) {
                        $stmtInsertEAD->bind_param("ssssssdsds", $id_equipo_ead, $nombre_indicador_ead, $diagrama_ead, $tipo_ead, $concepto_ead, $alcance_ead, $cantidad_ead, $um_ead, $co2_ead, $ref_ead);
                        $stmtInsertEAD->execute();
                        
                        $nuevo_id = $conexionEAD->insert_id;
                        $nuevos_ids_eads[] = $nuevo_id;
                        $hubo_inserciones = true;
                    } else {
                        $nuevos_ids_eads[] = null;
                    }
                }
            }
            
            if ($stmtUpdateEAD) $stmtUpdateEAD->close();
            if ($stmtInsertEAD) $stmtInsertEAD->close();
            $conexionEAD->close();
            
            if ($hubo_inserciones) {
                $json_ids_actualizado = json_encode($nuevos_ids_eads, JSON_UNESCAPED_UNICODE);
                $stmtUpdateOpex = $conexion->prepare("UPDATE proyectos_creados SET id_eads = ? WHERE id = ?");
                if ($stmtUpdateOpex) {
                    $stmtUpdateOpex->bind_param("si", $json_ids_actualizado, $id);
                    $stmtUpdateOpex->execute();
                    $stmtUpdateOpex->close();
                }
            }
        }

        $anioXmes = !is_array($anioXmes) ? json_decode($anioXmes, true) : $anioXmes;
        $mesXAnio = !is_array($mesXAnio) ? json_decode($mesXAnio, true) : $mesXAnio;
        $valoresMensualCO = !is_array($valoresMensualCO) ? json_decode($valoresMensualCO, true) : $valoresMensualCO;
        $valoresMensualAD = !is_array($valoresMensualAD) ? json_decode($valoresMensualAD, true) : $valoresMensualAD;
        $valoresMensualAS = !is_array($valoresMensualAS) ? json_decode($valoresMensualAS, true) : $valoresMensualAS;
        $idsPlanMesual = !is_array($idsPlanMesual) ? json_decode($idsPlanMesual, true) : $idsPlanMesual;
        $mesesPresupuestados = !is_array($mesesPresupuestados) ? json_decode($mesesPresupuestados, true) : $mesesPresupuestados;

        $cantidad_ids = is_array($idsPlanMesual) ? count($idsPlanMesual) : 0;
        $cantidad_meses = is_array($mesXAnio) ? count($mesXAnio) : 0;
        
        if ($cantidad_ids > 0) {
            for ($i = 0; $i < $cantidad_meses; $i++) {
                $co = $valoresMensualCO[$i] ?? '';
                $ad = $valoresMensualAD[$i] ?? '';
                $as = $valoresMensualAS[$i] ?? '';
                $mp = $mesesPresupuestados[$i] ?? '';

                $updPlan = "UPDATE plan_mensual_por_proyecto SET mes='$mesXAnio[$i]', anio='$anioXmes[$i]', ahorro_co='$co', ahorro_d='$ad', ahorro_s='$as', mes_presupuestado='$mp' WHERE id='$idsPlanMesual[$i]' AND id_proyecto='$id'";
                if ($conexion->query($updPlan) !== TRUE) {
                    $estado = $conexion->error . " Incorrecto";
                    break;
                } else {
                    $estado = true;
                }   
            }  
        } else {
            if (!empty(array_filter((array)$valoresMensualCO)) || !empty(array_filter((array)$valoresMensualAD)) || !empty(array_filter((array)$valoresMensualAS)) || !empty(array_filter((array)$mesesPresupuestados))) {
                for ($i = 0; $i < $cantidad_meses; $i++) {
                    $co = $valoresMensualCO[$i] ?? '';
                    $ad = $valoresMensualAD[$i] ?? '';
                    $as = $valoresMensualAS[$i] ?? '';
                    $mp = $mesesPresupuestados[$i] ?? '';

                    $insPlan = "INSERT INTO plan_mensual_por_proyecto (id_proyecto, mes, anio, ahorro_co, ahorro_d, ahorro_s, mes_presupuestado) VALUES ('$id', '$mesXAnio[$i]', '$anioXmes[$i]', '$co', '$ad', '$as', '$mp')";
                    if ($conexion->query($insPlan) !== TRUE) {
                        $estado = $conexion->error . " Incorrecto";
                        break;
                    } else {
                        $estado = true;
                    }
                }
            }
        }
    } else {
        return "ERROR: " . $stmt->error;
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


function actualizarRechazo($id_proyecto,$status_rechazo,$motivo,$anio,$mes)
{
    global $conexion;
    $estado = false;

    if($status_rechazo=="Corregida"){
        $update = "UPDATE registros_impacto_ambiental JOIN impacto_ambiental_proyecto 
        ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id 
        JOIN proyectos_creados 
        ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id SET registros_impacto_ambiental.status_rechazo = ? WHERE proyectos_creados.id=? AND registros_impacto_ambiental.mes =? AND registros_impacto_ambiental.anio = ?";
        $stmt = $conexion->prepare($update);
        if(!$stmt){
            return $conexion->error;
        }else{
            $stmt->bind_param("siii", $status_rechazo,$id_proyecto,$mes,$anio);
            if ($stmt->execute()) {
                $estado = true;
            }else{
                $estado = $stmt->error;
            }
            $stmt->close();
            return $estado;
        }

    }else{
        $update = "UPDATE registros_impacto_ambiental JOIN impacto_ambiental_proyecto 
        ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id 
        JOIN proyectos_creados 
        ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id SET registros_impacto_ambiental.status_rechazo = ?, registros_impacto_ambiental.motivo_rechazo=? WHERE proyectos_creados.id=? AND registros_impacto_ambiental.mes =? AND registros_impacto_ambiental.anio = ?";
        $stmt = $conexion->prepare($update);
        if(!$stmt){
            return $conexion->error;
        }else{
            $stmt->bind_param("ssiii", $status_rechazo,$motivo,$id_proyecto,$mes,$anio);
            if ($stmt->execute()) {
                 $estado = true;
            }else{
                $estado = $stmt->error;
            }
            $stmt->close();
            return $estado;
        }

    }
   
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


