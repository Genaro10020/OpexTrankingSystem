<?php
include("conexionGhoner.php");
    function consultarFuentes(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM fuentes ORDER BY id DESC";
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

    function insertarFuente($nueva,$siglas){
        global $conexion;
        $query = "INSERT INTO fuentes (nombre,siglas) VALUES (?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $nueva,$siglas);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }
        $stmt->close();
        return $estado;
    }

    function actualizarFuente($id,$nuevo,$siglas){
        global $conexion;
        $estado = false;
        $update = "UPDATE fuentes SET nombre=?,siglas=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssi", $nuevo, $siglas, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarFuente($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM fuentes WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>