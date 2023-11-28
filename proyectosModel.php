<?php
include("conexionGhoner.php");
    function consultarProyectos(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM proyectos_creados ORDER BY folio ASC";
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

    function consultarProyectosID($id_proyecto){
        global $conexion;
        $resultado = [];
        $estado= false;
            $consulta = "SELECT * FROM proyectos_creados WHERE id ='$id_proyecto'";
            $query = $conexion->query($consulta);
            if($query){
                while($datos=mysqli_fetch_array($query)){
                    $resultado [] = $datos;
                }
                    $estado = true;
            } else {
                    $estado = false;
            }
            return array ($resultado,$estado);
    }

    function insertarProyecto($folio,$fecha_alta,$nombre_proyecto,$planta,$area,$departamento,$metodologia,$responsable_id,$misiones,$pilares,$objetivos,$impacto_ambiental,$tons_co2,$ahorro_duro,$ahorro_suave){


        

        global $conexion;
        $folio_sin_numero = "";
        $folio_recuperado = "";
        $igual="";
        $numero = 1;
        $ultimoNum = "";
        $select = "SELECT folio FROM proyectos_creados WHERE folio LIKE '$folio%' ORDER BY id DESC LIMIT 1";
        $query= $conexion->query($select);
                if($query){
                    $estado_folios= true;
                    if($query->num_rows>0){
                        $fila = $query->fetch_assoc();
                        $folio_recuperado = $fila['folio'];   
                        $partes = explode("#",$folio_recuperado);
                        $folio_sin_numero = rtrim($partes[0],"-");

                            if($folio==$folio_sin_numero){//comparo el folio recuperado
                                $ultimoNum = end($partes);
                                $numero = intval($ultimoNum) + 1;
                                $igual = "Si";
                            }else{
                                $igual = "No";
                            }
                    }  
                }else{
                    $estado_folios = false;
                }

        $nuevo_folio=$folio."-#".$numero;//agrego el numero que sigue al folio
        $consulta = "SELECT * FROM responsables WHERE id = $responsable_id";
        $query = $conexion->query($consulta);
        if($query->num_rows>0){
             //Recuperado el responsable inserto
            $fila = $query->fetch_assoc();
            $nombre_responsable = $fila['nombre'];
            $correo_responsable =  $fila['correo'];
            $telefono_responsable =  $fila['telefono'];

            $separando = explode("-", $fecha_alta);
            $fecha_invertida = $separando[2] . "-" . $separando[1] . "-" . $separando[0];
            $estado  = true;
             //Inserto el proyecto
                    $query = "INSERT INTO proyectos_creados (folio,fecha, nombre_proyecto, planta, area, departamento, metodologia, responsable,correo,telefono, misiones,pilares,objetivos,impacto_ambiental, tons_co2, ahorro_duro, ahorro_suave) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("sssssssssssssssss",$nuevo_folio, $fecha_invertida,$nombre_proyecto,$planta,$area,$departamento,$metodologia, $nombre_responsable,$correo_responsable,$telefono_responsable,$misiones,$pilares,$objetivos,$impacto_ambiental,$tons_co2,$ahorro_duro,$ahorro_suave);
                    if($stmt->execute()){
                        $estado = true;
                        //insertado el proyecto, ahora inserto los impactos ambientales en otra tabla
                                        $insercion_impacto = "Correcto";
                                        $ultimo_id = $conexion->insert_id;
                                        $impacto_ambiental_array = json_decode($impacto_ambiental, JSON_UNESCAPED_UNICODE);
                                            foreach ($impacto_ambiental_array as $impacto) {
                                                    $consulta = "INSERT INTO impacto_ambiental_proyecto (id_proyecto,impacto_ambiental) VALUES ('$ultimo_id','$impacto')";
                                                    if ($conexion->query($consulta) !== TRUE) {
                                                        $insercion_impacto = "Incorreco";
                                                        break;
                                                    }
                                            }
                    }
                    $stmt->close();
        }else{
            $estado  = false;
        }

        return array($estado,$estado_folios,$folio_recuperado,$folio_sin_numero,$igual,$insercion_impacto,$impacto_ambiental_array);
        
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