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
    $consulta="SELECT proyectos_creados.responsable,proyectos_creados.correo,proyectos_creados.telefono,proyectos_creados.nombre_proyecto,proyectos_creados.id,proyectos_creados.fecha, proyectos_creados.objetivos, registros_impacto_ambiental.mes,proyectos_creados.status_seguimiento /*Proyectos por año Unicos listado de proyectos a mostrar*/
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

function insertarProyecto($folio, $fecha_alta_invertida, $nombre_proyecto, $fuente, $planta, $area, $departamento, $metodologia, $responsable_id, $observador, $misiones, $pilares, $objetivos, $impacto_ambiental,$impacto_ambiental_emisiones, $valores, $tons_co2, $ahorro_duro, $ahorro_suave,$anioXmes,$mesXAnio,$valoresMensualCO,$valoresMensualAD,$valoresMensualAS)
{
    global $conexion;
    $folio_sin_numero = "";
    $folio_recuperado = "";
    $igual = "";
    $numero = 1;
    $ultimoNum = "";
    $impacto_mensual ="";
    /*if($observador=='[""]'){
        $observador = "";
    }*/
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

        $estado  = true;
        //Inserto el proyecto
        $query = "INSERT INTO proyectos_creados (folio,fecha, fuente, nombre_proyecto, planta, area, departamento, metodologia,nomina, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental,valores, tons_co2, ahorro_duro, ahorro_suave,observador) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssssssssssssssss", $nuevo_folio, $fecha_alta_invertida, $fuente, $nombre_proyecto, $planta, $area, $departamento, $metodologia, $nomina, $nombre_responsable, $correo_responsable, $telefono_responsable, $misiones, $pilares, $objetivos, $impacto_ambiental_emisiones,$valores, $tons_co2, $ahorro_duro, $ahorro_suave,$observador);
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
                //insertando impactos mensuales
                $anioXmes = json_decode($anioXmes, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
                $mesXAnio = json_decode($mesXAnio, JSON_UNESCAPED_UNICODE);//conviertiendo arreglos en cadena
                $valoresMensualCO = json_decode($valoresMensualCO, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
                $valoresMensualAD = json_decode($valoresMensualAD, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
                $valoresMensualAS = json_decode($valoresMensualAS, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos

            $cantidad_meses=count($mesXAnio);
            for ($i=0; $i < $cantidad_meses; $i++) { 
                $insertar = "INSERT INTO plan_mensual_por_proyecto (id_proyecto, 	mes, 	anio, 	ahorro_co, 	ahorro_d, 	ahorro_s) VALUES ('$ultimo_id','$mesXAnio[$i]','$anioXmes[$i]','$valoresMensualCO[$i]','$valoresMensualAD[$i]','$valoresMensualAS[$i]')";
                if ($conexion->query($insertar) !== TRUE) {
                    $impacto_mensual = $conexion->error." Incorreco";
                    break;
                }else{
                    $impacto_mensual = "Correcto";
                }
            }
        }
        $stmt->close();
    } else {
        $estado  = false;
    }

    return array($estado, $estado_folios, $folio_recuperado, $folio_sin_numero, $igual, $insercion_impacto, $impacto_ambiental_array,$impacto_mensual);
}

function actualizarProyecto($id,$fecha_alta_invertida, $nombre_proyecto, $selectFuente, $planta, $area, $departamento, $metodologia, $responsable_id, $observador,$impacto_ambiental, $impacto_ambiental_emisiones,$valores,$anioXmes,$mesXAnio,$valoresMensualCO,$valoresMensualAD,$valoresMensualAS,$idsPlanMesual){
    global $conexion;
    $estado = false;




    ////////////////////////////
    $consulta = "SELECT * FROM responsables WHERE id = $responsable_id";
    $query = $conexion->query($consulta);
    if ($query->num_rows > 0) {
        //Recuperado el responsable inserto
        $fila = $query->fetch_assoc();
        $nomina = $fila['numero_nomina'];
        $nombre_responsable = $fila['nombre'];
        $correo_responsable =  $fila['correo'];
        $telefono_responsable =  $fila['telefono'];
        $estado  = true;
        }else {
        $estado  = false;
    }
///////////////////////////
    $update = "UPDATE proyectos_creados SET fecha=?, nombre_proyecto=?, fuente=?, planta=?, area=?, departamento=?, metodologia=?, responsable=?, nomina=?, correo=?, telefono=?, observador =?, impacto_ambiental=?, valores=? WHERE  id=?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("ssssssssssssssi",$fecha_alta_invertida, $nombre_proyecto, $selectFuente, $planta, $area, $departamento, $metodologia, $nombre_responsable, $nomina, $correo_responsable, $telefono_responsable, $observador, $impacto_ambiental_emisiones, $valores, $id);
    if ($stmt->execute()) {
         //insertando impactos mensuales
         $anioXmes = json_decode($anioXmes, JSON_UNESCAPED_UNICODE); //conviertiendo arreglos en cadena
         $mesXAnio = json_decode($mesXAnio, JSON_UNESCAPED_UNICODE);//conviertiendo arreglos en cadena
         $valoresMensualCO = json_decode($valoresMensualCO, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
         $valoresMensualAD = json_decode($valoresMensualAD, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
         $valoresMensualAS = json_decode($valoresMensualAS, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
         $idsPlanMesual = json_decode($idsPlanMesual, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos
         $impacto_ambiental = json_decode($impacto_ambiental, JSON_UNESCAPED_UNICODE);//conviertiendo a arreglos

         $estado = true;
         $impacto_ambiental_existentes= [];
         $diferentes = [];
        $consulta = "SELECT * FROM impacto_ambiental_proyecto WHERE id_proyecto = $id";
        $query = $conexion->query($consulta);
        if ($query->num_rows > 0) {
            //Recuperado el responsable inserto
            
            //$fila = $query->query_result();
            while ($datos = mysqli_fetch_array($query)) {
                    $impacto_ambiental_existentes[] = $datos['impacto_ambiental'];
                }
            $diferentes = array_diff($impacto_ambiental, $impacto_ambiental_existentes);
            //diferentes    impacto_ambiental_existentes impacto_ambiental
        }
        $taminio = count($diferentes);
        if($taminio>0){//Si hay diferentes insertarlo en la tabla de lo contrario no hacer nada
            foreach ($diferentes as $impacto) {
                $consulta = "INSERT INTO impacto_ambiental_proyecto (id_proyecto,impacto_ambiental) VALUES ('$id','$impacto')";
                if ($conexion->query($consulta) !== TRUE) {
                    $insercion_impacto = "Incorrecto";
                    break;
                }
            } 
        }
       


         //con filter elimino todos los "" y si todos estan vacios no se actualizara, de lo contrario actualizara.
         $cantidad_meses=count($mesXAnio);
         $cantidad_ids=count($idsPlanMesual);
        
            
            if($cantidad_ids>0){//Existe y actualiza
                        $cantidad_meses=count($mesXAnio);
                        for ($i=0; $i < $cantidad_meses; $i++) { 
                            $insertar = "UPDATE plan_mensual_por_proyecto SET mes='$mesXAnio[$i]',anio ='$anioXmes[$i]',ahorro_co = '$valoresMensualCO[$i]',ahorro_d = '$valoresMensualAD[$i]',ahorro_s = '$valoresMensualAS[$i]' WHERE id='$idsPlanMesual[$i]' AND id_proyecto='$id'";
                        if ($conexion->query($insertar) !== TRUE) {
                            $estado = $conexion->error." Incorreco";
                                break;
                        }else{
                            $estado = true;
                        }   
                    }  
                }else{//No existe y si no son vacias inserta
                    if (!empty(array_filter($valoresMensualCO)) && !empty(array_filter($valoresMensualAD)) && !empty(array_filter($valoresMensualAS))){
                            for ($i=0; $i < $cantidad_meses; $i++) { 
                                $insertar = "INSERT INTO plan_mensual_por_proyecto (id_proyecto, mes, anio,	ahorro_co, ahorro_d, ahorro_s) VALUES ('$id','$mesXAnio[$i]','$anioXmes[$i]','$valoresMensualCO[$i]','$valoresMensualAD[$i]','$valoresMensualAS[$i]')";
                                    if ($conexion->query($insertar) !== TRUE) {
                                        $estado = $conexion->error." Incorreco";
                                            break;
                                    }else{
                                        $estado = true;
                                    }
                            }
                    }
                }


    }else{
        return  "ME RETORNO".$stmt->error;
    }
    $stmt->close();
   //return array($estado,print_r($impacto_ambiental_existentes),print_r($diferentes));
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


