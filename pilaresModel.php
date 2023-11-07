<?php
include("conexionGhoner.php");
    function consultarPilares(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM pilares";
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


    function insertarPilares($nueva,$siglas,$id_mision){
            global $conexion;
            $resultado = [];
            $estado = false;

            $insertar = "INSERT INTO pilares (nombre,siglas,id_misiones) VALUES (?,?,?)";
            $stmt = $conexion->prepare($insertar);
            $stmt->bind_param("ssi",$nueva,$siglas,$id_mision);
            if($stmt->execute()){
                $estado = true;
            }

        return $estado;
       $stmt->close();
    }

    function consultarPilaresIDmisiones($idsMisiones){
        global $conexion;
        $resultado = [];
        $resultado2 = [];
        $idsPilares = [];
        $estado = false;
        $tamanio=count($idsMisiones);
        
            for ($i=0; $i < $tamanio; $i++) { 
                $consulta = "SELECT * FROM pilares WHERE id_misiones = '$idsMisiones[$i]'";
                $query = $conexion->query($consulta);
                if($query){
                    while ($datos=mysqli_fetch_array($query)){
                        $resultado [] = $datos;
                        $idsPilares [] = $datos['id'];
                    }
                        $estado  = true;
                }
            }
        return array ($resultado,$estado);
    }

    function eliminarPilar($id){
        global $conexion;
        $estado = false;
        $delete = "DELETE FROM pilares WHERE id=?";
        $stmt = $conexion->prepare($delete);
        $stmt->bind_param("i", $id); 
        if($stmt->execute()){
            $estado = true;
        }
        return  $estado;
    }
?>