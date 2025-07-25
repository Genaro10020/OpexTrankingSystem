<?php
include("conexionGhoner.php");
function consultarSeguimientos($anio)
{
    global $conexion;
    $pilasconSiglas = [];
    $objetivosconSiglas = [];
    $pilaresArreglos = [];
    $objetivosArreglos = [];
    $estadoPilar = false;
    $estadoObjetivos = false;
    $estadoProyectos = false;
    $estadoSeguimiento = false;
    $estadoProyectos= false;
    $check=[];
    $consulta = "SELECT * FROM pilares ORDER BY id DESC";
    $query = $conexion->query($consulta);
    if ($query) {
        $estadoPilar  = true;
        while ($datos = mysqli_fetch_array($query)) {
            $pilasconSiglas[] = $datos['nombre'] . (' (' . $datos['siglas'] . ')'); //concateno los nombres de pilar con siglas para compara en proyectos creados
        }
    }

    $consulta2 = "SELECT * FROM objetivos ORDER BY id DESC";
    $query2 = $conexion->query($consulta2);
    if ($query2) {
        $estadoObjetivos  = true;
        while ($datos = mysqli_fetch_array($query2)) {
            $objetivosNombre[] = $datos['nombre'] . (' (' . $datos['siglas'] . ')');
            $objetivosconSiglas[] = $datos['nombre'] . (' (' . $datos['siglas'] . ')->directo');  //concateno los nombres de objetivos, siglas y fecha para compara en proyectos creados
        }
    }

    $consultados = "SELECT * FROM proyectos_creados";
    $query = $conexion->query($consultados);
    if ($query) {
        $estadoProyectos = true;
        while ($pilares = $query->fetch_assoc()) {
            $id_pilar = $pilares['id'];
            $pilaresArreglos[$id_pilar] = json_decode($pilares['pilares']); //obtengo los arreglos de la columna pilares y decodifico
            $objetivosArreglos[$id_pilar] = json_decode($pilares['objetivos']); //obtengo los arreglos de la columna pilares y decodifico
        }
    }


    //COMPARO LOS PILARES DE PROYECTOS CREADOS CON CADA PILAR EXISTENTE PARA TOMAR EL ID DEL PROYECTO QUE COINCIDA
    // Inicializar un array para almacenar las claves agrupadas por coincidencias
    $idsConcidenConCadaPilar = [];
    // Iterar sobre $pilaresArreglos
    foreach ($pilaresArreglos as $clave => $valores) {
        // Encontrar las coincidencias entre los valores y $pilasconSiglas
        $coincidencias = array_intersect($valores, $pilasconSiglas);

        // Si hay coincidencias, agruparlas por valor en $idsConcidenConCadaPilar
        foreach ($coincidencias as $coincidencia) {
            $idsConcidenConCadaPilar[$coincidencia][] = $clave;
        }
    }

    //COMPARO LOS OBJETIVOS DE PROYECTOS CREADOS CON CADA OBJETIVO EXISTENTE, PARA TOMAR EL ID DEL PROYECTO QUE COINCIDA
    // Inicializar un array para almacenar las claves agrupadas por coincidencias
    $posicionNombresconIdsObjetivos = [];
    // Iterar sobre $pilaresArreglos
    foreach ($objetivosArreglos as $clave => $valores) {
        // Encontrar las coincidencias entre los valores y $pilasconSiglas
        $coincidencias = array_intersect($valores, $objetivosconSiglas);

        // Si hay coincidencias, agruparlas por valor en $idsConcidenConCadaPilar
        foreach ($coincidencias as $coincidencia) {
            $nombreObjetivo = str_replace('->directo', '', $coincidencia);
            $posicionNombresconIdsObjetivos[$nombreObjetivo][] = $clave;
        }
    }

    // Array para almacenar los resultados
    $sumasPorObjetivo = [];
    $sume = [];
    // Iterar sobre los objetivos
    foreach ($objetivosNombre as $objetivoNombre) {
        // Buscar el nombre del objetivo en el arreglo de posiciones
        if (isset($posicionNombresconIdsObjetivos[$objetivoNombre])) {
            // Obtener los IDs asociados al objetivo
            $idsProyecto = $posicionNombresconIdsObjetivos[$objetivoNombre];

            // Array para almacenar los resultados específicos de este objetivo
            $resultadosObjetivo = [];
            $sumaDato = 0.0;
            $sumaTonsCo2 = 0.0;
            $sumaAhorroDuro = 0.0;
            $sumaAhorroSuave = 0.0;
            $valor = 0.0;
            $sustentable = "0.00";
            $sumaSustentableFormateada ='0.00';
            // Consultar la tabla impacto_ambiental_proyecto para cada ID de proyecto
            foreach ($idsProyecto as $idProyecto) {
                // Realizar la consulta (ajusta según tu estructura de base de datos)
                $consulta = "SELECT 
                DISTINCT registros_impacto_ambiental.mes,registros_impacto_ambiental.ahorro_suave,registros_impacto_ambiental.ahorro_duro, registros_impacto_ambiental.tons_co2 
                FROM registros_impacto_ambiental JOIN  impacto_ambiental_proyecto ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto 
                WHERE impacto_ambiental_proyecto.id_proyecto = '$idProyecto' AND registros_impacto_ambiental.anio LIKE '$anio%'";
                $resultado = $conexion->query($consulta);
                // Verificar si la consulta fue exitosa
                if ($resultado) {
                    $estadoSeguimiento = true;
                    $pilar=$pilaresArreglos[$idProyecto][0];
                    // Procesar los resultados y almacenarlos en el array
                    while ($fila = $resultado->fetch_assoc()) {
                       
                        // Convertir la columna "tons_co2" a float y sumarla
                        $ahorro_duro = str_replace(['$', ','], '', $fila['ahorro_duro']); // Eliminar símbolo de dólar y comas
                        $ahorro_suave = str_replace(['$', ','], '', $fila['ahorro_suave']); // Eliminar símbolo de dólar y comas
                        //$sumeAhorroDuro[] = $sumaAhorroDuro;

                        $sumaAhorroDuro += floatval($ahorro_duro);
                        $sumaAhorroSuave += floatval($ahorro_suave);
                        $ahorros[] = $sumaAhorroDuro;
                        $idProyets[] = $idProyecto;

                        $sumaTonsCo2 += floatval($fila['tons_co2']);
                        //$sumaDato += floatval($fila['dato']);

                        $valor = $sumaAhorroDuro + $sumaAhorroSuave;
                        //$sustentable = $sumaTonsCo2 + $sumaDato;
                        $sustentable = $sumaTonsCo2;
                        // Formatear la suma de sustentable con formato de moneda
                        $sumaSustentableFormateada = '$' . number_format($valor, 2, '.', ',');
                       
                        $sustentable = number_format($sustentable, 2, '.', ',');
                    }
                } else {
                    // Manejar el error de la consulta
                    $estadoSeguimiento = "Error en la consulta: " . $conexion->error;
                }
            }

            // Almacenar los resultados específicos de este objetivo en el array principal
            $sumasPorObjetivo[$objetivoNombre] = [
                'valor' => $sumaSustentableFormateada,//ahorros (Valor)
                'sustentable' => $sustentable,//sustentable (Sustentable)
                'pilar'=>$pilar
            ];
        }
    }

    //$objetivosNombre, $idsConcidenConCadaPilar, $posicionNombresconIdsObjetivos
    return array($pilasconSiglas, $estadoPilar, $estadoObjetivos, $estadoProyectos, $sumasPorObjetivo, $estadoSeguimiento,$pilaresArreglos,$estadoProyectos,$anio,$ahorros,$idProyets);
}


function guardarSeguimietoInicial($id_proyecto, $mes, $anio, $toneladas, $inputImpactoAmbiental, $suave, $duro)
{
    global $conexion;
    $resultado = [];
    $error = "";
    $largo = 0;
    $existe = false;
    $id = intval($id_proyecto);
    $estado1 = false;
    $estado2 = false;
    $estado3 = false;
    $query = "SELECT id FROM impacto_ambiental_proyecto WHERE id_proyecto =?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        return $estado1 = "Error en la consulta" . $conexion->error;;
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $estado1 = true;
            $recuperando = $stmt->get_result();
            while ($fila = $recuperando->fetch_assoc()) {
                $ids_impactos[] = $fila;
            }
            $stmt->close();
            $largo = count($ids_impactos);
            $id_impacto = 0;
            $mes = (int)$mes;
            $anio = (int)$anio;
            $mes_anio = $mes . "-" . $anio;

            $query = "SELECT registros_impacto_ambiental.mes_anio FROM  registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE impacto_ambiental_proyecto.id_proyecto = ? AND registros_impacto_ambiental.mes_anio = ?";
            $stmt = $conexion->prepare($query);
            if ($stmt) {
                $estado2 = true;
                $stmt->bind_param("is", $id_proyecto, $mes_anio);
                $stmt->execute();
                $resultados = $stmt->get_result();
                $cantidad = $resultados->num_rows;
                $anio_mes_en_tabla = "";
                while ($row = $resultados->fetch_assoc()) {
                    $anio_mes_en_tabla = $row['mes_anio'];
                }
                if ($resultados->num_rows > 0 || $anio_mes_en_tabla == $mes_anio) {
                    $existe = true;
                } else {
                    for ($i = 0; $i < $largo; $i++) {
                        $id_impacto = $ids_impactos[$i]['id'];

                        if (isset($inputImpactoAmbiental[$i]) && $inputImpactoAmbiental[$i]){
                            $datos = $inputImpactoAmbiental[$i];
                            $query_insert = "INSERT INTO registros_impacto_ambiental (id_impacto_ambiental_proyecto,mes,anio,tons_co2,mes_anio,dato,ahorro_suave,ahorro_duro) VALUES (?,?,?,?,?,?,?,?)";
                            $stmt_insert = $conexion->prepare($query_insert);
                            if ($stmt_insert) {
                                $stmt_insert->bind_param("iiisssss", $id_impacto, $mes, $anio, $toneladas, $mes_anio, $datos, $suave, $duro);
                                if ($stmt_insert->execute()) {
                                    $estado3 = true;
                                } else {
                                    $estado3 = false;
                                }
                                $stmt_insert->close();
                            } else {
                                return $estado3 = "Error en la preparación de la consulta de inserción: " . $conexion->error;
                            }
                        }
                    }
                }

                $stmt->close();
            } else {
                $estado2 = "Error en la preparación de la consulta: " . $conexion->error;
            }

            // Después del bucle, puedes devolver solo el estado, ya que el array $ids_impactos no parece ser necesario en este contexto
            return array($estado1, $estado2, $estado3, $existe, $ids_impactos, $id_impacto, $cantidad, $anio_mes_en_tabla, $mes_anio);
        } else {
            $estado1 = "Error en la ejecución de la consulta";
        }
    }
}


function insertarProyecto($id_proyecto)
{
}

function actualizarRegistroImpactoAmbiental($id_proyecto, $mes, $anio, $toneladas, $idsInputImpactoAmbiental, $inputImpactoAmbiental, $suave, $duro)
{
    global $conexion;
    $id = intval($id_proyecto);
    $estado = false;
    $mes = (int)$mes;
    $anio = (int)$anio;
    $mes_anio = $mes . "-" . $anio;
    $cantidad_registro = count($idsInputImpactoAmbiental);
    $vueltas = 0;
    $existe = false;
    $query = "SELECT registros_impacto_ambiental.id AS id_registros, registros_impacto_ambiental.mes_anio, impacto_ambiental_proyecto.id AS idImpactoAmbiental FROM  registros_impacto_ambiental JOIN impacto_ambiental_proyecto ON impacto_ambiental_proyecto.id = registros_impacto_ambiental.id_impacto_ambiental_proyecto WHERE impacto_ambiental_proyecto.id_proyecto = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id_proyecto);
        $stmt->execute();
        $resultados = $stmt->get_result();
        $idsRegistrosBD = [];
        $idsImpactosConRegistro = [];
        while ($row = $resultados->fetch_assoc()) { //recupero columnas id impacto y mes_anio de tabla registros, con anio y  id en consulta
            if ($mes_anio == $row['mes_anio']) {
                $idsRegistrosBD[] = $row['id_registros']; // tomo los ids que contiene mismo mes y anio
                $idsImpactosConRegistro[] = $row['idImpactoAmbiental'];
            }
        }
        
        if (!empty($idsRegistrosBD)) {
            for ($i = 0; $i < $cantidad_registro; $i++) {
                $id = $idsInputImpactoAmbiental[$i]; //continen los id de la tabla registros_impacto_ambiental
                $dato = $inputImpactoAmbiental[$i];

                $update = "UPDATE registros_impacto_ambiental SET mes=?,anio=?,tons_co2=?,mes_anio=?,dato=?,ahorro_suave=?,ahorro_duro=? WHERE  id=?"; //,mes_anio=? pendiente
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("iisssssi", $mes, $anio, $toneladas, $mes_anio, $dato, $suave, $duro, $id);
                if ($stmt->execute()) {
                    $estado = true;
                } else {
                    return $estado = "No se actualizo el registro: " . $stmt->error;
                }
            }
        } else {

        }
        $diferenciaTamanio = "No";
        $diferencias = [];
        $cantidad_diferentes  = 0;
         $cantidad_existentes = 0;
        $datonuevo = "";  
        $impactoBDTablaImpactoAmbiental = [];
        if(count($idsRegistrosBD)!=count($inputImpactoAmbiental)){
            $consulta = "SELECT * FROM impacto_ambiental_proyecto WHERE id_proyecto = ?";//recupero los ids de impacto ambietal del proyecto
            $stmt = $conexion->prepare($consulta);
            if($stmt){
                $stmt->bind_param('i',$id_proyecto);
                $stmt->execute();
                $resultado = $stmt->get_result();
                while($datos = $resultado->fetch_assoc()){
                        $impactoBDTablaImpactoAmbiental[]=  $datos['id'];
                }
            }else{
                $estado = false;
            }
             $diferenciaTamanio = "Si";
             $diferencias = array_diff($impactoBDTablaImpactoAmbiental, $idsImpactosConRegistro);
             $diferencias = array_values($diferencias);// Resetear los índices para tener un arreglo limpio
            
             $cantidad_existentes=count($idsImpactosConRegistro);   
             $cantidad_diferentes = count($diferencias);
             
             if($inputImpactoAmbiental[$cantidad_diferentes-1]){
                        for ($i=0; $i < $cantidad_diferentes; $i++) { 
                                $id_impacto =  $diferencias[$i];
                                if(isset($inputImpactoAmbiental[$cantidad_existentes+$i]) && $inputImpactoAmbiental[$cantidad_existentes+$i]){
                                    $datonuevo = $inputImpactoAmbiental[$cantidad_existentes+$i];//Evito los que ya existen para insertar los que no BUSCAR EL CORRECTO PARA INSRETAR
                                    $query_insert = "INSERT INTO registros_impacto_ambiental (id_impacto_ambiental_proyecto,mes,anio,tons_co2,mes_anio,dato,ahorro_suave,ahorro_duro) VALUES (?,?,?,?,?,?,?,?)";
                                    $stmt_insert = $conexion->prepare($query_insert);
                                    if ($stmt_insert) {
                                        $stmt_insert->bind_param("iiisssss", $id_impacto, $mes, $anio, $toneladas, $mes_anio, $datonuevo, $suave, $duro);
                                        if ($stmt_insert->execute()) {
                                        $estado = true;
                                        } else {
                                            $estado = false;
                                        }
                                        $stmt_insert->close();
                                    } else {
                                        return $estado = "Error en la preparación de la consulta de inserción: " . $conexion->error;
                                    }
                                }
                                
                    }
             }else{
                $diferenciaTamanio .= ", pero no existe la posicion";
             }
            
        }
    

        //consultar los ids impacto existentes, verificar elque no exista para insertar
        /*
        if(!empty($diferencias)){
            $existe = false;

        }else{
            $existe = true;
        }*/
    } else {
        $estado = "Error en la preparación de la consulta: " . $conexion->error;
    }
    $stmt->close();
    return array($estado, $existe, $idsInputImpactoAmbiental, $idsRegistrosBD,$inputImpactoAmbiental,$diferenciaTamanio,$idsImpactosConRegistro,$impactoBDTablaImpactoAmbiental,$diferencias,$cantidad_diferentes,$datonuevo);
}

function eliminarArea()
{
}
