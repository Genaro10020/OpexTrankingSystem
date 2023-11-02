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

    function consultarPilaresID($idsPilares){
        global $conexion;
        $resultado = [];
        $resultado2 = [];
        $idsMisiones = [];
        $estado = false;
        $tamanio=count($idsPilares);
        
            for ($i=0; $i < $tamanio; $i++) { 
                $consulta = "SELECT * FROM pilares WHERE id = '$idsPilares[$i]' LIMIT 1";
                $query = $conexion->query($consulta);
                if($query){
                    while ($datos=mysqli_fetch_array($query)){
                        $resultado [] = $datos;
                        $idsMisiones [] = $datos['id_misiones'];
                    }
                        $estado  = true;
                }
            }
          
       
         $idsMisioneNoRepetidos = array_values(array_unique($idsMisiones));
         $tamanioMisiones = count($idsMisioneNoRepetidos);

         for ($i=0; $i < $tamanioMisiones; $i++) { 
            $consulta = "SELECT * FROM misiones WHERE id = '$idsMisioneNoRepetidos[$i]' LIMIT 1";
                $query = $conexion->query($consulta);
                if($query){
                    while ($datos=mysqli_fetch_array($query)){
                        $resultado2 [] = $datos;
                    }
                        $estado  = true;
                }
         }

        return array ($resultado,$estado,$resultado2);
    }
?>