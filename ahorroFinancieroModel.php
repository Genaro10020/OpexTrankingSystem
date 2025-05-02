<?php
include("conexionGhoner.php");
    function consultarAhorroFinanciero($anio){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM validacion_mensual_por_proyecto WHERE anio = '$anio'";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado);
    }

    function insertarAhorroFinanciero($id_proyecto, $anio, $mes, $ahorroFinanciero){
        global $conexion;
        $estado = false;

            $consulta = "SELECT * FROM validacion_mensual_por_proyecto WHERE id_proyecto=? AND anio=? AND mes =?";
            $stmt = $conexion->prepare($consulta);
            $stmt->bind_param("iii", $id_proyecto,$anio, $mes);
            $stmt->execute();
            $result = $stmt->get_result();
                if($result->num_rows > 0){
                        $update = "UPDATE validacion_mensual_por_proyecto SET valor=? WHERE id_proyecto=? AND anio=? AND mes =?";
                        $stmt = $conexion->prepare($update);
                        $stmt->bind_param("diii", $ahorroFinanciero,$id_proyecto,$anio, $mes);
                        if($stmt->execute()){
                            $estado = true;
                        }else{
                            $estado = false;
                        }
                }else{
                        $query = "INSERT INTO validacion_mensual_por_proyecto (id_proyecto, anio, mes, valor) VALUES (?,?,?,?)";
                        $stmt = $conexion->prepare($query);
                        $stmt->bind_param("siid", $id_proyecto, $anio, $mes, $ahorroFinanciero);
                        if($stmt->execute()){
                            $estado = true;
                        }else{
                            $estado = false;
                        }
                }
            $stmt->close();
            return $estado;
       
    }
//hiciste cambios aqui arriba ^^////

    function actualizarArea($id,$nuevo,$siglas){
        global $conexion;
        $estado = false;
        $update = "UPDATE areas SET nombre=?, siglas =? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssi", $nuevo,$siglas, $id);
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