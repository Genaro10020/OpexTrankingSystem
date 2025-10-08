<?php
include("conexionGhoner.php");
    function consultarImpactoAmbiental(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM impacto_ambiental ORDER BY id DESC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function sumaImpactoAmbiental(){
        global $conexion;
        $resultado =[];
        $sumas =[];
        $estado = false;
        $nombre_anterior = "";
        $consulta = "SELECT impacto_ambiental_proyecto.impacto_ambiental,  registros_impacto_ambiental.id_impacto_ambiental_proyecto, registros_impacto_ambiental.dato 
        FROM registros_impacto_ambiental JOIN impacto_ambiental_proyecto 
        ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id 
        ORDER BY `impacto_ambiental_proyecto`.`impacto_ambiental` DESC";
        if($query = $conexion->query($consulta)){
            $estado = true;
            while ($fila = mysqli_fetch_array($query)) {
                $limpiando = str_replace(['$', ','], '', $fila['dato']);
                $dato = floatval($limpiando);
    
                // Asignando el nombre a la variable
                $impacto_actual = $fila['impacto_ambiental'];
                
                if (!isset($sumas[$impacto_actual])) {
                    // Formatear el resultado anterior después de la inicialización
                    if ($nombre_anterior !== "") {
                        $sumas[$nombre_anterior] = number_format($sumas[$nombre_anterior], 2, '.', ',');
                    }
    
                    $sumas[$impacto_actual] = 0; // Inicializar la suma para el impacto actual
                    $nombre_anterior = $impacto_actual;
                }
                
                $sumas[$impacto_actual] += $dato;
            }
    
            // Formatear el último resultado después de salir del bucle
            if ($nombre_anterior !== "") {
                $sumas[$nombre_anterior] = number_format($sumas[$nombre_anterior], 2, '.', ',');
            }
        }else{
            $estado = false;
        }
        $resultado = $sumas; 
    
       return array($resultado,$estado);
    
    }

    function consultarImpactosAmbientalesConDatos($id_proyecto){
        global $conexion; 
        $respuesta=[];
        $status = false;
        $seleccion = "SELECT DISTINCT A.impacto_ambiental FROM impacto_ambiental_proyecto A INNER JOIN registros_impacto_ambiental B ON A.id = B.id_impacto_ambiental_proyecto WHERE A.id_proyecto = ? ";
        $stmt = $conexion->prepare($seleccion);
        if($stmt){
            $stmt->bind_param("i", $id_proyecto);
            if($stmt->execute()){
                $status = true;
                $recuperacion=$stmt->get_result();
                while($datos = $recuperacion->fetch_array()){
                    $nombre_impacto=$datos['impacto_ambiental'];
                    //Despues de recuparar los impactos con registro los busco en la tabla impacto ambiental para recuprar con sus respentivos ids
                    $selecc = "SELECT * FROM impacto_ambiental WHERE nombre = ?";
                    $stmt2 = $conexion->prepare($selecc);
                    if($stmt2){
                        $stmt2->bind_param("s", $nombre_impacto);
                        if($stmt2->execute()){
                            $recuperacion2=$stmt2->get_result();
                            while($fila = $recuperacion2->fetch_array()){
                                $respuesta[] = $fila;
                            }
                        }else{
                            $status = "Consulta tabla impacto ambiental: ".$stmt->error;
                        }
                    }else{
                        $status = "Consulta tabla impacto ambiental: ".$conexion->error;
                    }
                }
            }else{
                $status = $stmt->error;
            }
        }else{
            $status = $conexion->error;
        }
        $stmt->close();
        return array($status, $respuesta);
    }

    function insertarImpactoAmbiental($nueva,$cantidad,$unidadMedida){
        global $conexion;
        $query = "INSERT INTO impacto_ambiental (nombre,cantidad,unidad_medida) VALUES (?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sss", $nueva,$cantidad,$unidadMedida);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarImpactoAmbiental($id,$nuevoNombre,$cantidad,$unidadMedida){
        global $conexion;
        $estado = false;
        $update = "UPDATE impacto_ambiental SET nombre=?, cantidad=?, unidad_medida=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("sssi", $nuevoNombre,$cantidad,$unidadMedida,$id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarImpactoAmbiental($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM impacto_ambiental WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>