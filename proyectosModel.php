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

    function insertarProyecto($fecha_alta,$nombre_proyecto,$planta,$area,$departamento,$metodologia,$responsable,$misiones,$pilares,$objetivos,$impacto_ambiental,$tons_co2,$ahorro_duro,$ahorro_suave){
        global $conexion;
        $estado = false;
        $query = "INSERT INTO proyectos_creados (fecha, nombre_proyecto, planta, area, departamento, metodologia, responsable, tons_co2, misiones,pilares,objetivos,impacto_ambiental,ahorro_duro, ahorro_suave) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssssssssss", $fecha_alta,$nombre_proyecto,$planta,$area,$departamento,$metodologia,$responsable,$tons_co2,$misiones,$pilares,$objetivos,$impacto_ambiental,$ahorro_duro,$ahorro_suave);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }


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