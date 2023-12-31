<?php
include("conexionGhoner.php");
    function consultarDepartamentos(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM departamentos ORDER BY id DESC";
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

   
    function insertarDepartamento($nueva,$siglas){
        global $conexion;
        $query = "INSERT INTO departamentos (nombre,siglas) VALUES (?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $nueva, $siglas);
        if($stmt->execute()){
            $estado = true;
        }else{
            $estado = false;
        }

        $stmt->close();
        return $estado;
    }

    function actualizarDepartamento($id,$nuevoNombre,$siglas){
        global $conexion;
        $estado = false;
        $update = "UPDATE departamentos SET nombre=?, siglas=? WHERE  id=?";
        $stmt = $conexion->prepare($update);
        $stmt->bind_param("ssi", $nuevoNombre,$siglas, $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }

    function eliminarDepartamento($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM departamentos WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $estado = true;
        }
        $stmt->close();
        return $estado;
    }
       
?>