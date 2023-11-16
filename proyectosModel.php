<?php
include("conexionGhoner.php");
    function consultarProyectos(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM proyectos_creados ORDER BY id ASC";
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

    function insertarProyecto($fecha_alta,$nombre_proyecto,$planta,$area,$departamento,$metodologia,$responsable_id,$misiones,$pilares,$objetivos,$impacto_ambiental,$tons_co2,$ahorro_duro,$ahorro_suave){
        global $conexion;

        $consulta = "SELECT * FROM responsables WHERE id = $responsable_id";
        $query = $conexion->query($consulta);
        if($query->num_rows>0){
            $fila = $query->fetch_assoc();
            $nombre_responsable = $fila['nombre'];
            $correo_responsable =  $fila['correo'];
            $telefono_responsable =  $fila['telefono'];

            $separando = explode("-", $fecha_alta);
            $fecha_invertida = $separando[2] . "-" . $separando[1] . "-" . $separando[0];
            $estado  = true;
            //Recuperado el responsable inserto
                    $query = "INSERT INTO proyectos_creados (fecha, nombre_proyecto, planta, area, departamento, metodologia, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental, tons_co2, ahorro_duro, ahorro_suave) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("ssssssssssssssss", $fecha_invertida,$nombre_proyecto,$planta,$area,$departamento,$metodologia, $nombre_responsable,$correo_responsable,$telefono_responsable,$misiones,$pilares,$objetivos,$impacto_ambiental,$tons_co2,$ahorro_duro,$ahorro_suave);
                    if($stmt->execute()){
                        $estado = true;
                    }
                    $stmt->close();

        }else{
            $estado  = false;
        }

       
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