<?php
include("conexionGhoner.php");
    function consultarMisiones(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM misiones ORDER BY id DESC";
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

    function consultarMisionesRelacionadas(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM pilares as a LEFT JOIN misiones as b on b.id = a.id_misiones"; //ACOMODAR LA CONSULTA POR QUE TE TRAE TODO REVUELTAO
            $query = $conexion->query($consulta);
        if($query){
            while($datos=mysqli_fetch_array($query)){
                $resultado [] = $datos;
            }
                $estado = true;
        } else{
                $estado = false;
        }
        return array ($resultado,$estado);
    }

    function insertarMision($nueva){
        global $conexion;
        $query = "INSERT INTO misiones (nombre) VALUES (?)";
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

    function eliminarMision($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM misiones WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>