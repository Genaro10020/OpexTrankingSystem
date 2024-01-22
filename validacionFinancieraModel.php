<?php
include("conexionGhoner.php");
    function consultarValidacion($anio){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM validacion_financiera WHERE anio='$anio'";
            $query = $conexion->query($consulta);
            if($query){
                while ($datos=mysqli_fetch_array($query)){
                    if($datos['validado']=="Si"){
                        $datos['validado']=true;
                    }else{
                        if($datos['validado']=="No"){
                            $datos['validado']=false;
                        }
                    }
                    $resultado [$datos['mes']] = $datos;
                }
                    $estado  = true;
            }else{
                    $estado  = false;
            }
            return array ($resultado,$estado);
    }

    function insertarValidacion($mes,$anio,$suave,$duro,$real_duro,$validar){
        global $conexion;
        $nomina = $_SESSION['nomina'];
        $nombre = $_SESSION['nombre'];
        if($validar==true || $validar==1){
            $validar="Si";
        }else{
            $validar="No";
        }
        $fecha = date("Y-m-d H:i:s");
        $query = "INSERT INTO validacion_financiera (nomina,nombre,mes,anio,total_suave,total_duro,real_duro,validado,fecha) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sssssssss", $nomina,$nombre,$mes,$anio,$suave,$duro,$real_duro,$validar,$fecha);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarValidacion($mes,$anio,$suave,$duro,$real_duro,$validar,$id){
        global $conexion;
        $estado = false;
        $nomina = $_SESSION['nomina'];
        $nombre = $_SESSION['nombre'];
        if($validar==true || $validar==1){
            $validar="Si";
        }else{
            $validar="No";
        }
        $fecha = date("Y-m-d H:i:s");
        
        if($validar=="Si"){
                $update = "UPDATE validacion_financiera SET nomina=?,nombre=?,mes=?,anio=?,total_suave=?,total_duro=?,real_duro=?,validado=?,fecha=? WHERE  id=?";
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("sssssssssi", $nomina,$nombre,$mes,$anio,$suave,$duro,$real_duro,$validar,$fecha,$id);
                if($stmt->execute()){
                    $estado = true;
                }
        }else{
                $update = "UPDATE validacion_financiera SET validado=? WHERE  id=?";
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("si", $validar,$id);
                if($stmt->execute()){
                    $estado = true;
        }

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