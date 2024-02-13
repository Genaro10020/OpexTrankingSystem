<?php
include("conexionGhoner.php");
    function consultarPlan($anio){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM plan_mensual WHERE anio='$anio'";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    $resultado [$datos['mes']] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function insertarPlan($mes,$anio,$valor,$id){
        global $conexion;
        $fecha = date("Y-m-d H:i:s");
        $query = "INSERT INTO plan_mensual (mes,anio,plan,fecha) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("iiss", $mes,$anio,$valor,$fecha);//double es (d) y fecha es (s)
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarPlan($valor,$id){
        global $conexion;
        $estado = false;
        $fecha = date("Y-m-d H:i:s");
                $update = "UPDATE plan_mensual SET plan=?,fecha=? WHERE id=?";
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("ssi", $valor,$fecha,$id);
                if($stmt->execute()){
                    $estado = true;
                }
        $stmt->close();
        return $estado;
    }

    function eliminarMetodologia($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM metodologias WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
?>