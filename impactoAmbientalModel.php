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