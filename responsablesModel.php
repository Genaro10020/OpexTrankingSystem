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



    function insertarResponsable($nombre,$nomina,$correo,$telefono,$financiero){
        global $conexion;
        $estado = false;
        $contrasena = "123456"; 
        if($financiero==true){
            $financiero = "Financiero";
            $contrasena = "Financiero.".$nomina; 
        }else{
            $financiero = "";
        }
        $insertar = "INSERT INTO responsables (nombre,numero_nomina,contrasena,correo,telefono,tipo_usuario) VALUES (?,?,?,?,?,?)";
        $stmt = $conexion->prepare($insertar);
        $stmt->bind_param("ssssss",$nombre,$nomina,$contrasena,$correo,$telefono,$financiero);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }



    function actualizarResponsable($id,$nombre,$numero_nomina,$correo,$telefono,$financiero){
        global $conexion;
        $estado = false;
        $contrasena = "123456"; 
        if($financiero==true){
            $financiero = "Financiero";
            $contrasena = "Financiero.".$numero_nomina; 
        }else{
            $financiero = "";
        }
        $update = "UPDATE responsables SET nombre=?, numero_nomina=?, contrasena=?, correo=?, telefono=?,tipo_usuario=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssssssi", $nombre,$numero_nomina,$contrasena,$correo,$telefono,$financiero, $id);
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