<?php
include("conexionGhoner.php");
    function consultarResponsables(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM responsables ORDER BY id DESC";
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

    function consultarResponsableID($id){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM responsables WHERE id = '$id'";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }
            return array ($resultado,$estado);
    }



    function insertarResponsable($nombre,$nomina,$correo,$telefono){
        global $conexion;
        $estado = false;
        $insertar = "INSERT INTO responsables (nombre,numero_nomina,correo,telefono) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
        $stmt->bind_param("ssss",$nombre,$nomina,$correo,$telefono);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }



    function actualizarResponsable($id,$nombre,$numero_nomina,$correo,$telefono){
        global $conexion;
        $estado = false;
        $update = "UPDATE responsables SET nombre=?, numero_nomina=?, correo=?, telefono=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssssi", $nombre,$numero_nomina,$correo,$telefono, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

   

    function eliminarResponsable($idResponsable){
        global $conexion;
        $estado = false;
        $eliminar = "DELETE FROM responsables WHERE id=?";
        $stmt = $conexion->prepare($eliminar);
        $stmt ->bind_param("i",$idResponsable);
        if($stmt->execute()){
            $estado = true;
        }
        return $estado;
    }



       
?>