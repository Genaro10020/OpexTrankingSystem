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
       
?>