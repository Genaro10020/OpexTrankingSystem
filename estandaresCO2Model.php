<?php
include("conexionGhoner.php");
    function consultarEstandaresCO2(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM estandares_co2 ORDER BY id DESC";
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

    function insertarEstandaresCO2($nueva,$cantidad,$unidadMedida){
        global $conexion;
        $query = "INSERT INTO estandares_co2 (nombre,cantidad,unidad_medida) VALUES (?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sis", $nueva,$cantidad,$unidadMedida);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarMetodologia($id,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE metodologias SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarEstandares($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM estandares_co2 WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>