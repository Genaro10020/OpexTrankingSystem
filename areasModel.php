<?php
include("conexionGhoner.php");
    function consultarAreas(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM areas ORDER BY id DESC";
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

    function insertarArea($nueva){
        global $conexion;
        $estado = false;
        $query = "INSERT INTO areas (nombre) VALUES (?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $nueva);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }


    function actualizarPlanta($idArea,$nuevoNombre){
        global $conexion;
        $estado = false;
        $update = "UPDATE areas SET nombre=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("si", $nuevoNombre, $idArea);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }


    function eliminarArea($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM areas WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }

        $stmt->close();
        return $estado;
    }
       
?>