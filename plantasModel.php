<?php
include("conexionGhoner.php");
    function consultarPlantas(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM plantas ORDER BY id DESC";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }
            return array ($resultado,$estado);
    }

    function insertarPlanta($nueva){
        global $conexion;
        $estado = false;
        $query = "INSERT INTO plantas (nombre) VALUES (?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $nueva);
        if($stmt->execute()){
            $estado = true;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarPlanta($idPlanta,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE plantas SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $idPlanta);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarPlanta($idPlanta){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM plantas WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $idPlanta);
        if($stmt->execute()){
            $estado = true;
        }

        $stmt->close();
        return $estado;
    }

       
?>