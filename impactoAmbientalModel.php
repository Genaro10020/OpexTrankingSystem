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

    function insertarImpactoAmbiental($nueva){
        global $conexion;
        $query = "INSERT INTO impacto_ambiental (nombre) VALUES (?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $nueva);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarImpactoAmbiental($id,$nuevo){
        global $conexion;
        $estado = false;
        $update = "UPDATE impacto_ambiental SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevo, $id);
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