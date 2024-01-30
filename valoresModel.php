<?php
include("conexionGhoner.php");
    function consultarValores(){
        global $conexion;
        $resultado = [];
        $estado = false;
            $consulta = "SELECT * FROM valores";
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

    function sumaImpactoAmbiental(){
    }

    function insertarImpactoAmbiental($nueva){
    }

    function actualizarImpactoAmbiental($id,$nuevo){
    }

    function eliminarImpactoAmbiental($id){
    }
?>