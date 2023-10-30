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

    function eliminarPilares(){
        
    }
?>