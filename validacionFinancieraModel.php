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
                $real_duro = "$0.00";
                $update = "UPDATE validacion_financiera SET validado=?,real_duro=? WHERE  id=?";
                $stmt = $conexion->prepare($update);
                $stmt->bind_param("ssi", $validar,$real_duro,$id);
                if($stmt->execute()){
                    $estado = true;
                }
        }
        
        $stmt->close();
        return $estado;
    }

    function actualizarValidacionProyecto($id, $anio, $mes,$validacion){
        global $conexion;
        $estado = false;
        $update = "UPDATE registros_impacto_ambiental
                   JOIN impacto_ambiental_proyecto 
                   ON registros_impacto_ambiental.id_impacto_ambiental_proyecto = impacto_ambiental_proyecto.id
                   JOIN proyectos_creados 
                   ON impacto_ambiental_proyecto.id_proyecto = proyectos_creados.id
                   SET registros_impacto_ambiental.validado = ?
                   WHERE proyectos_creados.id = ? 
                   AND registros_impacto_ambiental.anio = ? 
                   AND registros_impacto_ambiental.mes = ?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("siii", $validacion, $id, $anio, $mes);
        if ($stmt->execute()) {
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