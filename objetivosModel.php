<?php
include("conexionGhoner.php");
    function consultarObjetivos(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM objetivos ORDER BY id DESC";
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

    function insertarObjetivo($nueva,$siglas,$id_pilar){
        global $conexion;
        $query = "INSERT INTO objetivos (nombre, siglas, id_pilares) VALUES (?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssi", $nueva, $siglas,$id_pilar);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarObjetivo($nombre,$siglas,$id_pilar,$id){
        global $conexion;
        $estado = false;
        $update = "UPDATE objetivos SET nombre=?, siglas=?, id_pilares=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssii", $nombre, $siglas, $id_pilar,$id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarObjetivo($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM objetivos WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>